<?php

class Api extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper("security");
        $this->load->library("security");
        $this->load->library("form_validation");
        $this->load->model("api_model");
        $this->load->config("api/api");
    }

    public function checkLogin()
    {
        //Check for API enabled status
        if ($this->config->item("api_enabled") == false) {
            $data["info"]["disabled"] = "API endpoint has been disabled!";
            die(json_encode($data));
        }

        //Check for API SecretKey
        if (empty($this->config->item("secret_key"))) {
            $data["info"]["secretkey"] = "Please setup your secretkey!";
            die(json_encode($data));
        }

        //Form Validation
        $this->form_validation->set_rules("username", "username", "trim|required|min_length[4]|max_length[24]|xss_clean|alpha_numeric");
        $this->form_validation->set_rules("password", "password", "trim|required|min_length[6]|xss_clean");
        $this->form_validation->set_rules("apikey",   "apikey",   "trim|required|xss_clean");

        $this->form_validation->set_error_delimiters('<div class="error">', "</div>");

        $data = [
            "messages" => false,
        ];

        if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["apikey"])) {
            
            if ($_POST["apikey"] == $this->config->item("secret_key")) {


                //Get the players IP address
                $ip_address = $this->input->ip_address();

                //Check if the IP address has been blocked
                $find = $this->api_model->getIP($ip_address);

                if ($find) {
                    if (time() < $find["block_until"]) {
                        // The IP address is blocked, calculate remaining minutes
                        $remaining_minutes = round(($find["block_until"] - time()) / 60);
                        $data["messages"]["error"] = lang("ip_blocked", "api") . "<br>" . lang("try_again", "api") . " " . "Lock Time" . $remaining_minutes . " " . lang("minutes", "api") . "<br>";
                        $data["info"]["lockminutes"] = $remaining_minutes;

                        die(json_encode($data));
                    }
                }

                //Check password
                $existsUser = $this->external_account_model->usernameExists($this->input->post("username"));
                if ($existsUser) {
                    if ($this->input->post("password") != "") {
                        $userId = $this->user->getId($this->input->post("username"));
                        $sha_pass_hash = $this->user->createHash($this->input->post("username"), $this->input->post("password"));

                        if (strtoupper($this->external_account_model->getInfo($userId, "password")["password"]) != strtoupper($sha_pass_hash["verifier"])) {
                            $this->increaseAttempts($ip_address);
                            $this->logger->createLog("user", "login", "Login", [], Logger::STATUS_FAILED, $this->user->getId($this->input->post("username")));
                            $data["messages"]["error"] = lang("error", "api");

                            die(json_encode($data));
                        }
                    }
                } else {
                    $this->increaseAttempts($ip_address);
                    $data["messages"]["error"] = lang("error", "api");
                    die(json_encode($data));
                }

                //Login
                if (!empty($_POST["username"]) && !empty($_POST["password"])) {
                    $sha_pass_hash = $this->user->createHash($this->input->post("username"), $this->input->post("password"));
                    $check = $this->user->setUserDetails($this->input->post("username"), $sha_pass_hash["verifier"]);

                    //if no errors, login
                    if ($check == 0) {
                        $this->session->unset_userdata("attempts");
                        $data["success"] = true;
                        $this->api_model->deleteIP($ip_address);
                        $this->logger->createLog("user", "login", "Login");

                        die(json_encode($data));
                    }
                }
            } else {
                $data["info"]["secretkey"] = "Invalid Secret Key!";
                die(json_encode($data));
            }
        } else {
            $data["success"] = false;
            die(json_encode($data));
        }
    }
    
    private function increaseAttempts($ip_address)
    {
        $find = $this->api_model->getIP($ip_address);

        $this->session->set_userdata(
            "attempts",
            $this->session->userdata("attempts") + 1
        );

        if (!empty($find["attempts"])) {
            //Update failed login attempts and last_attempt
            $ip_data = [
                "attempts" => $find["attempts"] + 1,
                "last_attempt" => date("Y-m-d H:i:s"),
            ];

            $this->api_model->updateIP($ip_address, $ip_data);
        } else {
            $ip_data = [
                "ip_address" => $ip_address,
                "attempts" => 1,
                "last_attempt" => date("Y-m-d H:i:s"),
            ];
            $this->api_model->insertIP($ip_data);
        }

        //Get new ip datas
        $find = $this->api_model->getIP($ip_address);

        if (
            !empty($find["attempts"]) &&
            $find["attempts"] >= $this->config->item("block_attemps")
        ) {
            //Block the IP address
            $block_until = time() + $this->config->item("block_duration") * 60;
            $block_data = [
                "block_until" => $block_until,
            ];

            $this->api_model->updateIP($ip_address, $block_data);
        }
    }
}

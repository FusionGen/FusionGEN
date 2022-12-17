<?php

class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('security');
        $this->load->library('security');
        $this->load->library('form_validation');
        $this->load->library('captcha');
		$this->load->config('captcha');

        requirePermission("view");
    }

    //Redirect to login
    public function index()
    {
        if ($this->user->isOnline()) {
            redirect($this->template->page_url . "ucp");
        } else {
            redirect($this->template->page_url . "login");
        }
    }

    //Login page
    public function login()
    {
        if ($this->user->isOnline()) {
            redirect($this->template->page_url . "ucp");
        }

        $data = array(
            "use_captcha" => false,
			"captcha_type" => $this->config->item('captcha_type')
        );

        if ($this->config->item("use_captcha") == true && (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
            $data["use_captcha"] = true;
        }

		$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("log_in", "auth"),
					"class" => array("class" => "page_form"),
					"content" => $this->template->loadPage("login.tpl", $data)
				)), "modules/auth/css/auth.css", "modules/auth/js/login.js");

    }

    public function register()
    {
        if ($this->user->isOnline()) {
            redirect($this->template->page_url . "ucp");
        }

        die("register");
    }

    public function checkLogin()
    {
        $fields = array("username", "password");
        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|max_length[14]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|xss_clean');

        if ($this->config->item("use_captcha") == true && (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
            $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|xss_clean');
        }

        $error = false;

        $data = array(
            "type" => "login",
            "redirect" => false,
            "exists" => false,
            "avatar" => "",
            "messages" => array(
            "username" => "",
            "password" => "",
            "captcha" => ""
            )
        );

        //Check if form errors
        if ($this->form_validation->run() == false) {
            if (count($_POST) > 0) {
                foreach ($fields as $field) {
                    if (empty($data["messages"][$field])) {
                        if (form_error($field) != "") {
                            $error = 1;
                        }
                        $data["messages"][$field] = form_error($field);
                    }
                }
            }
        }

        //Check Captcha
        if ($this->config->item("use_captcha") == true && (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
            $data['showCaptcha'] = true;

            if ($this->input->post('captcha') != $this->captcha->getValue()) {
                $data['messages']["captcha"] = lang("captcha_invalid", "auth");
				$error = true;
            }
        }

        //Check Username & Password
        $existsUser = $this->external_account_model->usernameExists($this->input->post("username"));

        if ($existsUser) { //if user exist
            $userId = $this->user->getId($this->input->post("username"));
            $data["exists"] = true;
            $data["avatar"] = $this->user->getAvatar($userId);

            if ($this->input->post("password") != "") {
                $sha_pass_hash = $this->user->createHash($this->input->post("username"), $this->input->post("password"));

                if (strtoupper($this->external_account_model->getInfo($userId, "password")["password"]) != strtoupper($sha_pass_hash["verifier"])) {
                    if (isset($_POST["submit"]) && $this->input->post("submit") == "true") {
                        $data["messages"]["password"] = lang("password_doesnt_match", "auth");
                    }
                    $error = true;
                }
            }
        } else { //if user doesnt exist
            $data["messages"]["username"] =  lang("user_doesnt_exist", "auth");
            $error = true;
        }

        if ($error == true) {
			if (isset($_POST["submit"]) && $this->input->post("submit") == "true") {
				$this->session->set_userdata('attempts', $this->session->userdata('attempts') + 1);
			}

            if ($this->config->item("use_captcha") == true && (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
                $data["showCaptcha"] = true;
            }
        }

        if (isset($_POST["submit"])) {
            if ($error == false && $this->input->post("submit") == "true") {
                $sha_pass_hash = $this->user->createHash($this->input->post('username'), $this->input->post('password'));
                $check = $this->user->setUserDetails($this->input->post('username'), $sha_pass_hash["verifier"]);

                //if no errors, login
                if ($check == 0) {
                    $data["redirect"] = true;

                    unset($_SESSION['captcha']);
                    $this->session->unset_userdata('attempts');

                    // Remember me
                    if (isset($_POST["remember"])) {
                        if ($this->input->post("remember") == "true") {
                            $this->input->set_cookie("fcms_username", $this->input->post('username'), 60 * 60 * 24 * 365);
                            $this->input->set_cookie("fcms_password", $sha_pass_hash["verifier"], 60 * 60 * 24 * 365);
                        }
                    }

					$this->external_account_model->setLastIp($this->user->getId(), $this->input->ip_address());
                    $this->plugins->onLogin($this->input->post('username'));
                }
            }
        }

        die(json_encode($data));
    }

    public function getCaptcha()
    {
        $this->captcha->generate();
        $this->captcha->output();
    }
}

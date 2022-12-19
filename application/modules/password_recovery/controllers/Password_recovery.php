<?php

class Password_recovery extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('password_recovery_model');

        $this->load->helper('email_helper');

        $this->user->guestArea();

        requirePermission("view");

        if (!$this->config->item('has_smtp')) {
            die(lang("smtp_disabled", "recovery"));
        }
    }

    public function index()
    {
        clientLang("email_sent", "recovery");

        $this->template->setTitle(lang("password_recovery", "recovery"));

        $data = array();

        $content = $this->template->loadPage("password_recovery.tpl", $data);
        $box = $this->template->box(lang("password_recovery", "recovery"), $content);
        $this->template->view($box, "modules/password_recovery/css/recovery.css", "modules/password_recovery/js/recovery.js");
    }

    public function createRequest($acc = false)
    {
        // timestamp | 10min delay for next request or captcha?
		if (!$acc || empty($acc)) {
            die('No account');
        }

        if ($acc) {
            $email = $this->password_recovery_model->getEmail($acc);

            $link = base_url() . 'password_recovery/requestPassword/' . $this->generateKey($acc, $email);
            sendMail($email, $this->config->item('server_name') . ': ' . lang("reset_password", "recovery"), $acc, lang("email", "recovery") . ' <a href="' . $link . '">' . $link . '</a>', 1);
        }

		die('yes');
    }

    public function requestPassword($key = "")
    {
        $key || $this->template->box(breadcumb(array(
            'password_recovery' => lang('password_recovery', 'recovery'),
        )), lang('no_key', 'recovery'), true);
        //var_dump ($key);

        $encryption = $this->realms->getEmulator()->encryption();
        //var_dump ($encryption);

        switch ($encryption) {
            case 'SHP':
                $username = $this->password_recovery_model->getKey($key);

                // Make sure that it is the right key
                $username || $this->template->box(breadcumb(array(
                    'password_recovery' => lang('password_recovery', 'recovery'),
                )), lang('invalid', 'recovery'), true);

                $password = $this->generatePassword(); //New password

                //Hash password for the database
                $newPasswordHash = sha1(strtoupper($username) . ':' . strtoupper($password));

                //Change the password
                $this->password_recovery_model->changePassword($username, $newPasswordHash);

                //Send a mail with the new password
                sendMail($this->password_recovery_model->getEmail($username), $this->config->item('server_name') . ': ' . lang("your_new_password", "recovery"), $username, lang("new_password", "recovery") . ' <b>' . $newPasswordHash . '</b>', 1);

                //Show a new message
                $this->template->view($this->template->loadPage("page.tpl", array(
                    "module" => "default",
                    "headline" => lang("password_recovery", "recovery"),
                    "content" => lang("changed", "recovery")
                )));

                //Remove the key from the database
                $this->password_recovery_model->deletekey($key);
                break;
            case 'SRP6':
            case 'HEX':
                $username = $this->password_recovery_model->getKey($key);

                // Make sure that it is the right key
                $username || $this->template->box(breadcumb(array(
                    'password_recovery' => lang('password_recovery', 'recovery'),
                )), lang('invalid', 'recovery'), true);

                $password = $this->generatePassword(); //New password
                $PW = $this->user->createHash($username, $password);

                // Hash the password through the current active emulator and set it for the user
                $this->password_recovery_model->changePassword_srp6($username, $PW['verifier']);

                // Send a mail with the new password
                sendMail($this->password_recovery_model->getEmail($username), $this->config->item('server_name') . ': ' . lang('your_new_password', 'recovery'), $username, lang('new_password', 'recovery') . ' <b>' . $password . '</b>', 1);

                // Remove the key from the database
                $this->password_recovery_model->deletekey($key);

                $this->template->box(breadcumb(array(
                    'password_recovery' => lang('password_recovery', 'recovery'),
                )), lang('changed', 'recovery'), true);
                break;
            default:
                $this->template->view($this->template->loadPage("page.tpl", array(
                "module" => "default",
                "headline" => lang("password_recovery", "recovery"),
                "content" => lang("invalid", "recovery")
                )));
                break;
        }
    }

    private function generateKey($username, $email)
    {
        $encryption = $this->realms->getEmulator()->encryption();

        switch ($encryption) {
            case 'SHP':
                $key = sha1($username . ":" . $email . ":" . time());

                if ($this->password_recovery_model->insertKey($key, $username, $email, $this->input->ip_address())) {
                    return $key; // a new key has been generated for the user
                }

                $this->template->box(breadcumb(array(
                    'password_recovery' => lang('password_recovery', 'recovery'),
                )), lang('error_while_inserting', 'recovery'), true);
                break;
            case 'SRP6':
            case 'HEX':
                $key = sha1($username . ':' . $email . ':' . time());

                if ($this->password_recovery_model->insertKey($key, $username, $email, $this->input->ip_address())) {
                    return $key; // a new key has been generated for the user
                }

                $this->template->box(breadcumb(array(
                    'password_recovery' => lang('password_recovery', 'recovery'),
                )), lang('error_while_inserting', 'recovery'), true);
                break;
            default:
                die();
                break;
        }
    }

    private function generatePassword()
    {
        return substr(sha1(time()), 0, 10);
    }
}

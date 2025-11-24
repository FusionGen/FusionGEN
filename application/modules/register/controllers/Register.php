<?php

class Register extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Make sure that we are not logged in yet
        $this->user->guestArea();

        requirePermission("view");

        $this->load->helper(['form', 'url', 'security']);
        $this->load->library('form_validation');

        $this->load->helper('email_helper');

        $this->load->config('captcha');
    }

    public function index()
    {
        clientLang("username_limit_length", "register");
        clientLang("username_limit", "register");
        clientLang("username_not_available", "register");
        clientLang("email_not_available", "register");
        clientLang("email_invalid", "register");
        clientLang("password_short", "register");
        clientLang("pw_dont_match", "register");
        clientLang("the_account", "register");
        clientLang("has_been_created_redirecting", "register");
        clientLang("user_panel", "register");

        $this->template->setTitle(lang("register", "register"));

        //Load the form validations for if they tried to sneaky bypass our js system
        $this->form_validation->set_rules('register_username', 'username', 'trim|required|min_length[4]|max_length[24]|alpha_numeric');
        $this->form_validation->set_rules('register_email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('register_password', 'password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('register_password_confirm', 'password confirmation', 'trim|required|matches[register_password]');

        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

        require_once('application/libraries/Captcha.php');

        $captchaObj = new Captcha($this->config->item('use_captcha'));

        // Handle AJAX request for validation or full submission
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $response = ['status' => 'error', 'errors' => []];

            if ($this->form_validation->run() == FALSE) {
                $response['errors']['register_username'] = form_error('register_username');
                $response['errors']['register_email'] = form_error('register_email');
                $response['errors']['register_password'] = form_error('register_password');
                $response['errors']['register_password_confirm'] = form_error('register_password_confirm');
            }

            // Custom checks for username and email availability
            if (!$this->username_check($this->input->post('register_username'))) {
                $response['errors']['register_username'] = '<div class="invalid-feedback">' . lang("username_not_available", "register") . '</div>';
            }

            if (!$this->email_check($this->input->post('register_email'))) {
                $response['errors']['register_email'] = '<div class="invalid-feedback">' . lang("email_not_available", "register") . '</div>';
            }

            // Captcha check if enabled
            if ($this->config->item('use_captcha') && strtoupper($this->input->post('register_captcha')) != strtoupper($captchaObj->getValue())) {
                $response['errors']['register_captcha'] = '<div class="invalid-feedback">Captcha error</div>';
            }

            if (empty($response['errors']) && $this->form_validation->run()) {
                // If all validations pass, create the account
                $this->external_account_model->createAccount($this->input->post('register_username'), $this->input->post('register_password'), $this->input->post('register_email'));

                // Log in the user
                $salt = $this->user->createHash($this->input->post('register_username'), $this->input->post('register_password'));
                $this->user->setUserDetails($this->input->post('register_username'), $salt["verifier"]);

                // Return success and instruct client to redirect
                die(json_encode(['status' => 'success']));
            } else {
                // Return validation errors
                die(json_encode($response));
            }
        }

        // Initial page load, display the form
        $data = [
            "use_captcha" => $this->config->item('use_captcha'),
            "captcha_type" => $this->config->item('captcha_type'),
            "url" => $this->template->page_url
        ];

        $this->template->view($this->template->loadPage("page.tpl", [
            "module" => "default",
            "headline" => lang("account_creation", "register"),
            "content" => $this->template->loadPage("register.tpl", $data),
        ]), false, "modules/register/js/validate.js");
    }

    public function username_check($username)
    {
        return !$this->external_account_model->usernameExists($username);
    }

    public function email_check($email)
    {
        return !$this->external_account_model->emailExists($email);
    }
}

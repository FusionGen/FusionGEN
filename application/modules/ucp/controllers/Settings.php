<?php

class Settings extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        $this->load->config('settings');
        $this->load->config('links');

        $this->load->library('form_validation');

        //Make sure that we are logged in
        $this->user->userArea();
    }

    public function index()
    {
        requirePermission("canUpdateAccountSettings");

        clientLang("nickname_error", "ucp");
        clientLang("location_error", "ucp");
        clientLang("pw_dont_match", "ucp");
        clientLang("password_limit_length", "ucp");
        clientLang("changes_saved", "ucp");
        clientLang("invalid_pw", "ucp");
        clientLang("nickname_taken", "ucp");
        clientLang("invalid_language", "ucp");

        $this->template->setTitle(lang("settings", "ucp"));

        $settings_data = [
            'nickname' => $this->user->getNickname(),
            'location' => $this->internal_user_model->getLocation(),
            'show_language_chooser' => $this->config->item('show_language_chooser'),
            'userLanguage' => $this->language->getLanguage(),
            "avatar" => $this->user->getAvatar($this->user->getId()),

            "config" => [
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "mod" => $this->config->item('ucp_mod')
            ]
        ];

        if ($this->config->item('show_language_chooser')) {
            $settings_data['languages'] = $this->language->getAllLanguages();
        }

        // Load the page breadcrumb
        $data = [
            "module" => "default",
            "headline" => breadcrumb([
                            "ucp" => lang("ucp"),
                            "ucp/settings" => lang("settings", "ucp")
                        ]),
            "content" => $this->template->loadPage("settings.tpl", $settings_data)
        ];

        $page = $this->template->loadPage("page.tpl", $data);

        //Load the template form
        $this->template->view($page, "modules/ucp/css/ucp.css", "modules/ucp/js/settings.js");
    }

    public function submit()
    {
        // Set validation rules
        $this->form_validation->set_rules('old_password', 'old password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('new_password_confirm', 'confirm password', 'trim|required|matches[new_password]');

        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

        if ($this->form_validation->run()) {
            // Check old password first
            $currentPassword = $this->user->getPassword();
            $passwordHash = $this->user->createHash($this->user->getUsername(), $this->input->post('old_password'));

            if (strtoupper($currentPassword) != strtoupper($passwordHash["verifier"])) {
                // Return old password error
                die (json_encode([
                    'status' => 'error',
                    'errors' => [
                        'old_password' => '<div class="invalid-feedback">'.lang("invalid_pw", "ucp").'</div>'
                    ]
                ]));
            }

            // Change password if old password is correct
            $newHash = $this->user->createHash($this->user->getUsername(), $this->input->post('new_password'));
            $this->user->setPassword($newHash["verifier"]);
            $this->plugins->onChangePassword($this->user->getId(), $newHash);

            die (json_encode(['status' => 'success']));
        }

        // Return validation errors
        die (json_encode([
            'status' => 'error',
            'errors' => [
                'old_password' => form_error('old_password'),
                'new_password' => form_error('new_password'),
                'new_password_confirm' => form_error('new_password_confirm')
            ]
        ]));
    }

    public function submitInfo()
    {
        $this->load->model("settings_model");

        // Set up validation rules
        $this->form_validation->set_rules('nickname', 'nickname', 'trim|required|min_length[4]|max_length[24]|alpha_numeric');
        $this->form_validation->set_rules('location', 'location', 'trim|max_length[32]|alpha');

        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

        $nickname = $this->input->post("nickname");
        $location = $this->input->post("location");

        if ($this->form_validation->run()) {
            // Update sanitization according to CMS standards
            $values = [
                'nickname' => $this->template->format($nickname, false, true, false),
                'location' => $this->template->format($location, false, true, false)
            ];

            // Custom validation for nickname uniqueness
            if ($nickname != $this->user->getNickname() && $this->internal_user_model->nicknameExists($nickname)) {
                // Return nickname error
                die (json_encode([
                    'status' => 'error',
                    'errors' => [
                        'nickname' => '<div class="invalid-feedback">'.lang("nickname_taken", "ucp").'</div>'
                    ]
                ]));
            }

            // Handle language if enabled
            if ($this->config->item('show_language_chooser')) {
                $language = $this->input->post('language');
                if (!is_dir("application/language/" . $language)) {
                    die (json_encode([
                        'status' => 'error',
                        'errors' => [
                            'language' => '<div class="invalid-feedback">'.lang("invalid_language", "ucp").'</div>'
                        ]
                    ]));
                }

                $values['language'] = $language;
                $this->user->setLanguage($values['language']);
                $this->plugins->onSetLanguage($this->user->getId(), $values['language']);
            }

            $this->settings_model->saveSettings($values);
            $this->plugins->onSaveSettings($this->user->getId(), $values);

            die(json_encode(['status' => 'success']));
        }

        // Return validation errors
        die(json_encode([
            'status' => 'error',
            'errors' => [
                'nickname' => form_error('nickname'),
                'location' => form_error('location')
            ]
        ]));
    }
}

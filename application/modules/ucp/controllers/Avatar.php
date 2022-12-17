<?php

class Avatar extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('settings');
        $this->load->model("settings_model");
    }

    public function index()
    {
        // Prepare data
        $content = array(
            'avatar' => $this->user->getAvatar(),
            'debug' => $this->config->item('avatar_upload_debug')
        );

        $title = breadcumb(array(
                            "ucp" => lang("ucp"),
                            "ucp/avatar" => lang("change_avatar", "ucp")
                        ));

        $data = array(
            "module" => "default",
            "headline" => $title,
            "content"  => $this->template->loadPage("avatar.tpl", $content)
        );

        $page = $this->template->loadPage("page.tpl", $data);

        //Load the template form
        $this->template->view($page, "modules/ucp/css/avatar.css", "modules/ucp/js/avatar.js");
    }

    public function upload()
    {
        $config['upload_path']          = './uploads/avatar/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2048;
        $config['encrypt_name']         = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());

            die(json_encode([
                'status' => 'error',
                'message' => $error
            ]));
        } else {
            $data = $this->upload->data();

            $avatar = $this->internal_user_model->getAvatar($this->user->getId());

            if ($avatar != 'default.gif') {
                unlink('./uploads/avatar/' . $avatar);
            }

            $this->settings_model->setAvatar($this->user->getId(), $data['file_name']);

            die();
        }
    }

    public function remove()
    {
        $this->settings_model->removeAvatar($this->user->getId());
        die('1');
    }
}

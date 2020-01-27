<?php

class Avatar extends MX_Controller
{
	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->config('avatar');
        $this->load->library('upload');
    }

	public function index()
	{
		// Prepare data
		$data = array(
		    'avatar' => $this->user->getAvatar($this->user->getId()),
		    'max_size' => $this->config->item('max_size'),
		    'max_width' => $this->config->item('max_width'),
		    'max_height' => $this->config->item('max_height'),
		    'allowed_types' => $this->config->item('allowed_types'),
		);

		// Load the avatar page
		$content = $this->template->loadPage("avatar.tpl", $data);

		$title = breadcumb(array(
							"ucp" => lang("ucp"),
							"ucp/avatar" => lang("change_avatar", "ucp")
						));

		// Put it in a content box
		$this->template->box($title, $content, true, "modules/ucp/css/avatar.css");
	}
	
    public function upload()
    {
		$this->load->model("avatar_model");

		// Prepare data
		$config = array(
		    'max_size' => $this->config->item('max_size'),
		    'max_width' => $this->config->item('max_width'),
		    'max_height' => $this->config->item('max_height'),
		    'allowed_types' => $this->config->item('allowed_types'),
		    'encrypt_name' => $this->config->item('encrypt_name'),
		    'xss_clean' => $this->config->item('xss_clean')
		);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('avatar'))
		    $data = array('error' => $this->upload->display_errors());
        else
        {
		    $this->avatar_model->setAvatar(array('avatar' => $this->upload->data('file_name')));
		    $data = array('error' => 'Success');
		}

		$title = breadcumb(array(
							"ucp" => lang("ucp"),
							"ucp/avatar" => lang("change_avatar", "ucp"),
							"ucp/avatar/upload" => lang("upload_avatar", "ucp"),
						));

		$page = $this->template->loadPage("upload.tpl", $data);

		$this->template->box($title, $page, true);
    }
}
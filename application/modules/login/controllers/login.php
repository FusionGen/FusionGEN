<?php

class Login extends MX_Controller
{
	function __construct()
	{
		//Call the constructor of MX_Controller
		parent::__construct();

		//Load url and form library
		$this->load->config('login');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$this->template->setTitle("Sign in");

		if($this->user->isOnline())
		{
			redirect($this->template->page_url . "ucp");
		}

		$data = array(
					"url" => $this->template->page_url,
					"username" => "",
					"username_error" => "",
					"password_error" => "",
					"captcha_error" => "",
					"use_captcha" => (int)$this->session->userdata('attempts') >= $this->config->item('captcha'),
					"class" => array("class" => "page_form"),
					"has_smtp" => $this->config->item('has_smtp')
				);

		// Form not submitted
		if(count($_POST) == 0)
		{
			$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("log_in", "login"),
					"class" => array("class" => "page_form"),
					"content" => $this->template->loadPage("login.tpl", $data)
				)));
		}
		else
		{
			if((int)$this->session->userdata('attempts') >= $this->config->item('captcha'))
			{
				$data['use_captcha'] = true;
				$this->load->library('captcha');

				if(!$this->captcha->getValue() || strcasecmp($this->input->post('login_captcha', true), $this->captcha->getValue()))
				{
					$check = 3; // custom error, captcha isn't valid
					$data['captcha_error'] = '<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" />';
				}
			}

			if(!isset($check)) // only if captcha is valid
			{
				$sha_pass_hash = $this->user->createHash($this->input->post('login_username'), $this->input->post('login_password'));
				$check = $this->user->setUserDetails($this->input->post('login_username'), $sha_pass_hash);
			}

			// No errors
			if($check == 0)
			{
				unset($_SESSION['captcha']); // @ignore
				$this->session->unset_userdata('attempts');

				if($this->input->post('login_remember'))
				{
					// Remember me
					$this->input->set_cookie("fcms_username", $this->input->post('login_username'), 60*60*24*365);
					$this->input->set_cookie("fcms_password", $sha_pass_hash, 60*60*24*365);
				}

				$this->plugins->onLogin($this->input->post('login_username'));

				// Redirect to the user panel
				redirect($this->template->page_url."ucp");
			}
			else
			{
				$data['username'] = $this->input->post('login_username');
				$this->session->set_userdata('attempts', $this->session->userdata('attempts') + 1);

				// Wrong username
				if($check == 1)
				{
					$data['username_error'] = '<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" data-tip="'.lang("user_doesnt_exist", "login").'" />';
					$data['password_error'] = '<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" data-tip="'.lang("password_doesnt_match", "login").'" />';
				}

				// Wrong password
				elseif($check == 2)
				{
					$data['password_error'] = '<img src="'.$this->template->page_url.'application/images/icons/exclamation.png" data-tip="'.lang("password_doesnt_match", "login").'" />';
					$data['username_error'] = '<img src="'.$this->template->page_url.'application/images/icons/accept.png" />';
				}

				$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("log_in", "login"), 
					"content" => $this->template->loadPage("login.tpl", $data)
				)));
			}
		}
	}

	public function is_logged_in()
	{
		$this->user->userArea();
	}
	
	public function is_not_logged_in()
	{
		$this->user->guestArea();
	}
}

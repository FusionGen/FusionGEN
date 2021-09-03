<?php

class Password_recovery extends MX_Controller
{	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->config('password_recovery');
		$this->load->model('password_recovery_model');

		$this->load->helper('email_helper');

		$this->user->guestArea();
		
		requirePermission("view");

		if(!$this->config->item('has_smtp'))
		{
			die(lang("smtp_disabled", "recovery"));
		}
	}
	
	public function index()
	{
		$this->template->setTitle("Password recovery");

		if($this->input->post('recover_username'))
		{
			$email = $this->password_recovery_model->getEmail($this->input->post('recover_username'));
			
			if($email)
			{
				$link = base_url().'password_recovery/requestPassword/'.$this->generateKey($this->input->post('recover_username'), $email);
				sendMail($email, $this->config->item('password_recovery_sender_email'), $this->config->item('server_name').': '.lang("reset_password", "recovery"), lang("email", "recovery").' <a href="'.$link.'">'.$link.'</a>');

				$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("password_recovery", "recovery"), 
					"content" => lang("email_sent", "recovery")
				)));
			}
			else
			{
				//Wrong username or an error occured
				$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("password_recovery", "recovery"), 
					"content" => lang("doesnt_exist", "recovery")." <a href=''>".lang("go_back", "recovery")."</a>",
				)));
			}
		}
		else
		{
			//Nothing in the email so they didnt filled in a username
			$this->template->view($this->template->loadPage("page.tpl", array(
				"module" => "default", 
				"headline" => lang("password_recovery", "recovery"), 
				"content" => $this->template->loadPage("password_recovery.tpl", array("class" => array("class" => "page_form")))
			)));
		}	
	}
	
	public function requestPassword($key = "")
	{
		if($key)
		{
			$key_valid = $this->password_recovery_model->getKey($key);
			//Make sure a key is entered and make sure that it is the right key
			if($key_valid && $key_valid != '')
			{
				//Reset password
				$username = $key_valid; //Username
				$newPassword = $this->generatePassword(); //New password
				
				//Hash password for the database
				$newPasswordHash = sha1(strtoupper($username).':'.strtoupper($newPassword));
				
				//Change the password
				$this->password_recovery_model->changePassword($username, $newPasswordHash);
				
				//Send a mail with the new password
				sendMail($this->password_recovery_model->getEmail($username), $this->config->item('password_recovery_sender_email'), $this->config->item('server_name').': '.lang("your_new_password", "recovery"), lang("new_password", "recovery").' <b>'.$newPassword.'</b>');
				
				//Show a new message
				$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("password_recovery", "recovery"), 
					"content" => lang("changed", "recovery")
				)));
				
				//Remove the key from the database
				$this->password_recovery_model->deletekey($key);
			}
			else
			{
				//Error occurred
				$this->template->view($this->template->loadPage("page.tpl", array(
					"module" => "default", 
					"headline" => lang("password_recovery", "recovery"), 
					"content" => lang("invalid_key", "recovery")
				)));
			}
		}
		else
		{
			$this->template->view($this->template->loadPage("page.tpl", array(
				"module" => "default", 
				"headline" => lang("password_recovery", "recovery"), 
				"content" => lang("no_key", "recovery")
			)));
		}
	}

	private function generateKey($username, $email)
	{
		$key = sha1($username.":".$email.":".time());
		
		if(!$this->password_recovery_model->insertKey($key, $username, $this->input->ip_address()))
		{
			$this->template->view($this->template->loadPage("page.tpl", array(
				"module" => "default", 
				"headline" => lang("password_recovery", "recovery"), 
				"content" => lang("error_while_inserting", "recovery")
			)));
		}	
		
		return $key;
	}
	
	private function generatePassword()
	{
		return substr(sha1(time()), 0, 10);
	}
}

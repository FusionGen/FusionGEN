<?php

class Password_recovery extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->user->guestArea();
		requirePermission('view');

		$this->load->config('password_recovery');

		if(!$this->config->item('has_smtp')) // system is disabled
			show_error(lang('smtp_disabled', 'recovery'));

		$this->load->helper('email_helper');
		$this->load->model('password_recovery_model');
	}

	public function index()
	{
		$this->template->setTitle('Password recovery');

		// Nothing in the email so they didnt filled in a username
		$this->input->post('recover_username') || $this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), $this->template->loadPage('password_recovery.tpl', ['class' => ['class' => 'page_form']]), true);

		$email = $this->password_recovery_model->getEmail($this->input->post('recover_username'));

		// Wrong username or an error occured
		$email || $this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('doesnt_exist', 'recovery').' <a href="' . base_url('password_recovery') . '">' . lang('go_back', 'recovery') . '</a>', true);

		$link = base_url('password_recovery/requestPassword/' . $this->generateKey($this->input->post('recover_username'), $email));
		sendMail($email, $this->config->item('password_recovery_sender_email'), $this->config->item('server_name') . ': ' .
			lang('reset_password', 'recovery'), lang('email', 'recovery') . " <a href=\"$link\">$link</a>");

		$this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('email_sent', 'recovery'), true);
	}

	public function requestPassword($key = '')
	{
		$key || $this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('no_key', 'recovery'), true);

		$username = $this->password_recovery_model->getKey($key);

		// Make sure that it is the right key
		$username || $this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('invalid_key', 'recovery'), true);

		// Generate a new password
		$password = $this->generatePassword();

		// Hash the password through the current active emulator and set it for the user
		$this->password_recovery_model->changePassword($username, $this->user->createHash($username, $password));

		// Send a mail with the new password
		sendMail($this->password_recovery_model->getEmail($username), $this->config->item('password_recovery_sender_email'), $this->config->item('server_name') . ': ' .
			lang('your_new_password', 'recovery'), lang('new_password', 'recovery') . ' <b>' . $password . '</b>');

		// Remove the key from the database
		$this->password_recovery_model->deletekey($key);

		$this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('changed', 'recovery'), true);
	}

	private function generateKey($username, $email)
	{
		$key = sha1($username.':'.$email.':'.time());

		if($this->password_recovery_model->insertKey($key, $username, $this->input->ip_address()))
			return $key; // a new key has been generated for the user

		$this->template->box(breadcumb(array(
			'password_recovery' => lang('password_recovery', 'recovery'),
		)), lang('error_while_inserting', 'recovery'), true);
	}

	private function generatePassword()
	{
		return substr(sha1(time()), 0, 10);
	}
}

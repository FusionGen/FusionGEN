<?php

class Smf extends Plugin
{
	/**
	 * Runtime values
	 */
	private $username;
	private $password;
	private $email;
	private $db;

	/**
	 * Receive the user information
	 * @param String $username
	 * @param String $password
	 * @param String email
	 */	
	public function register($username, $password, $email)
	{
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		
		$this->db = $this->CI->load->database($this->CI->config->item('bridge'), TRUE);

		$this->process();
	}

	/**
	 * Add the account
	 */
	private function process()
	{
		$password = $this->encryptPassword();

		$this->db->query("INSERT INTO ".$this->CI->config->item('forum_table_prefix')."members(`member_name`, `passwd`, `email_address`, `real_name`, `date_registered`) VALUES(?, ?, ?, ?, ?)", array($this->username, $password, $this->email. $this->username, time()));
	}

	/**
	 * Encrypt the password with a specific algorithm
	 * @return String
	 */
	private function encryptPassword()
	{
		return sha1(strtolower($this->username) . $this->password);
	}
}
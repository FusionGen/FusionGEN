<?php

class Ipb extends Plugin
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
		$salt = $this->generatePasswordSalt(5);
		$salt = str_replace( '\\', "\\\\", $salt );

		$password = $this->encryptPassword($salt);

		$key = $this->generateAutoLoginKey();
		$expire = time() + 86400;

		$this->db->query("INSERT INTO ".$this->CI->config->item('forum_table_prefix')."members(`name`, `members_pass_hash`, `email`, `members_display_name`, `joined`, `members_pass_salt`, `member_login_key`, `member_login_key_expire`, `members_l_display_name`, `members_l_username`, `members_seo_name`, `member_group_id`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '3')", array($this->username, $password, $this->email, $this->username, time(), $salt, $key, $expire, $this->username, $this->username, $this->username));
	}

	/**
	 * Encrypt the password with a specific algorithm
	 * @return String
	 */
	private function encryptPassword($salt)
	{
		return md5( md5($salt) . md5( $this->password ) );
	}

	private function generateAutoLoginKey( $len=60 )
	{
		$pass = $this->generatePasswordSalt( $len );

		return md5($pass);
	}

	private function generatePasswordSalt($len=5)
	{
		$salt = '';

		for ( $i = 0; $i < $len; $i++ )
		{
			$num   = mt_rand(33, 126);

			if ( $num == '92' )
			{
				$num = 93;
			}

			$salt .= chr( $num );
		}

		return $salt;
	}
}
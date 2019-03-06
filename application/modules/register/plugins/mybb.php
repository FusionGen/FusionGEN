<?php

class Mybb extends Plugin
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
		$salt = $this->random_str();
		$password = $this->encryptPassword($salt);
		$now = time();
		$loginkey = $this->random_str(50);
		$ip = $this->CI->input->ip_address();

		$this->db->query("INSERT INTO ".$this->CI->config->item('forum_table_prefix')."users (`username`, `password`, `salt`, `loginkey`, `email`, `usergroup`, `regdate`, `lastactive`, `lastvisit`, `website`, `icq`, `aim`, `yahoo`, `msn`, `birthday`, `signature`, `allownotices`, `hideemail`, `subscriptionmethod`, `receivepms`, `pmnotice`, `pmnotify`, `showsigs`, `showavatars`, `showquickreply`, `invisible`, `style`, `timezone`, `dst`, `threadmode`, `daysprune`, `regip`, `longregip`, `language`, `showcodebuttons`, `tpp`, `ppp`, `referrer`, `buddylist`, `ignorelist`, `pmfolders`, `notepad`, `showredirect`, `usernotes`) VALUES (?, ?, ?, ?, ?, '2', ?, ?, ?, '', '', '', '', '', '', '', '1', '0', '0', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0', '', '0', ?, INET_ATON(?), '', '1', '0', '0', '0', '', '', '', '', '1', '')", array($this->username, $password, $salt, $loginkey, $this->email, $now, $now, $now, $ip, $ip));
	}

	/**
	 * Encrypt the password with a specific algorithm
	 * @return String
	 */
	private function encryptPassword($salt)
	{
		return md5(md5($salt) . md5($this->password));
	}
	
	/**
	 * Generates a random set of number and characters
	 * @return String
	 */
	private function random_str($max = 8)
	{
        $chars = explode(" ", "A a B b C c D d E e F f G g H h I i J j K k L l M m N n O o P p Q q R r S s T t U u V v W w X x Y y Z z 1 2 3 4 5 6 7 8 9");
		$rtn = '';
        for($i = 0; $i < $max; $i++)
		{
            $rtn .= str_replace('=', '', base64_encode(md5($chars[array_rand($chars)])));
        }
        return substr(str_shuffle($rtn), 0, $max);
    }
}
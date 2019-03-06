<?php

class Phpbb extends Plugin
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

		$this->db->query("INSERT INTO ".$this->CI->config->item('forum_table_prefix')."users(`username`, `user_password`, `user_email`, `username_clean`, `user_regdate`, `user_new`, `group_id`) VALUES(?, ?, ?, ?, ?, '1','2')", array($this->username, $password, $this->email, $this->username, time()));

		$this->db->select('user_id');
		$this->db->where('username', $this->username);
		$res = $this->db->get($this->CI->config->item('forum_table_prefix').'users');
		$row = $res->row();

		$this->db->query("INSERT INTO ".$this->CI->config->item('forum_table_prefix')."user_group(group_id, user_id, user_pending) VALUES('2', ?, '0')", array($row->user_id));

		$this->db->select('group_colour');
		$this->db->where('group_id', 2);
		$res = $this->db->get($this->CI->config->item('forum_table_prefix').'groups');
		$row2 = $res->row();

		$this->db->set('config_value', $row->user_id);
		$this->db->where('config_name', 'newest_user_id');
		$this->db->update($this->CI->config->item('forum_table_prefix').'config');

		$this->db->set('config_value', $this->username);
		$this->db->where('config_name', 'newest_username');
		$this->db->update($this->CI->config->item('forum_table_prefix').'config');

		$this->db->set('config_value', $row2->group_colour);
		$this->db->where('config_name', 'newest_user_colour');
		$this->db->update($this->CI->config->item('forum_table_prefix').'config');

		$this->db->set('config_value', 'config_value + 1');
		$this->db->where('config_name', 'num_users');
		$this->db->update($this->CI->config->item('forum_table_prefix').'config');
	}

	/**
	 * Encrypt the password with a specific algorithm
	 * @return String
	 */
	private function encryptPassword()
	{
		$password = $this->password;

		$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		$random_state = uniqid();
		$random = '';
		$count = 6;

		if (($fh = @fopen('/dev/urandom', 'rb')))
		{
			$random = fread($fh, $count);
			fclose($fh);
		}

		if (strlen($random) < $count)
		{
			$random = '';

			for ($i = 0; $i < $count; $i += 16)
			{
				$random_state = md5(uniqid() . $random_state);
				$random .= pack('H*', md5($random_state));
			}
			$random = substr($random, 0, $count);
		}

		$hash = _hash_crypt_private($password, _hash_gensalt_private($random, $itoa64), $itoa64);

		if (strlen($hash) == 34)
		{
			return $hash;
		}

		return md5($password);
	}
}

/**
* The crypt function/replacement
*/
function _hash_crypt_private($password, $setting, &$itoa64)
{
	$output = '*';

	// Check for correct hash
	if (substr($setting, 0, 3) != '$H$' && substr($setting, 0, 3) != '$P$')
	{
		return $output;
	}

	$count_log2 = strpos($itoa64, $setting[3]);

	if ($count_log2 < 7 || $count_log2 > 30)
	{
		return $output;
	}

	$count = 1 << $count_log2;
	$salt = substr($setting, 4, 8);

	if (strlen($salt) != 8)
	{
		return $output;
	}

	/**
	* We're kind of forced to use MD5 here since it's the only
	* cryptographic primitive available in all versions of PHP
	* currently in use.  To implement our own low-level crypto
	* in PHP would result in much worse performance and
	* consequently in lower iteration counts and hashes that are
	* quicker to crack (by non-PHP code).
	*/
	if (PHP_VERSION >= 5)
	{
		$hash = md5($salt . $password, true);
		do
		{
			$hash = md5($hash . $password, true);
		}
		while (--$count);
	}
	else
	{
		$hash = pack('H*', md5($salt . $password));
		do
		{
			$hash = pack('H*', md5($hash . $password));
		}
		while (--$count);
	}

	$output = substr($setting, 0, 12);
	$output .= _hash_encode64($hash, 16, $itoa64);

	return $output;
}

/**
* Generate salt for hash generation
*/
function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
{
	if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
	{
		$iteration_count_log2 = 8;
	}

	$output = '$H$';
	$output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
	$output .= _hash_encode64($input, 6, $itoa64);

	return $output;
}

/**
* Encode hash
*/
function _hash_encode64($input, $count, &$itoa64)
{
	$output = '';
	$i = 0;

	do
	{
		$value = ord($input[$i++]);
		$output .= $itoa64[$value & 0x3f];

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 8;
		}

		$output .= $itoa64[($value >> 6) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 16;
		}

		$output .= $itoa64[($value >> 12) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		$output .= $itoa64[($value >> 18) & 0x3f];
	}
	while ($i < $count);

	return $output;
}
<?php

class Create_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function insertMessage($user_id, $sender_id, $title, $message)
	{
		$this->db->query("INSERT INTO private_message (`user_id`, `sender_id`, `message`, `time`, `title`) VALUES (?, ?, ?, ?, ?)", array($user_id, $sender_id, $message, time(), $title));
	}

	public function getUsersLike($username)
	{
		$this->db->select('nickname')->from('account_data')->like('nickname', $username)->limit(5);
		$query = $this->db->get();
		$result = $query->result_array();

		if($query->num_rows() == 0)
		{
			return false;
		}
		elseif($query->num_rows() == 1
		&& $result[0]['nickname'] == $username)
		{
			return true;
		}
		else
		{
			$usernames = array();

			foreach($result as $value)
			{
				array_push($usernames, $value['nickname']);
			}

			usort($usernames, 'sortIt');

			if(in_array($username, $usernames))
			{
				return true;
			}
			else
			{
				return $usernames;
			}
		}
	}
}

function sortIt($a, $b)
{
	return strlen($a) - strlen($b);
}
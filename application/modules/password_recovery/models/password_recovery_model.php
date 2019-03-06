<?php

class Password_recovery_model extends CI_Model
{
	private $connection;
	
	public function __construct()
	{
		if(empty($this->connection))
		{
			$this->connection = $this->load->database("account", true);
		}
	}
	
	public function getEmail($username)
	{
		if(!$username)
		{
			return false;
		}
		else
		{
			$query = $this->connection->query("SELECT ".column("account", "email")." FROM ".table("account")." WHERE ".column("account", "username"). "= ?", array($username));
	
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();

				return $result[0]['email'];
			}
			else 
			{
				return false;	
			}
		}
	}
	
	public function changePassword($username, $newPassword)
	{
		if($username && $newPassword)
		{
			$this->connection->query("UPDATE ".table("account")." SET ".column("account", "password")." = ?, ".column("account", "sessionkey")." = '', ".column("account", "v")." = '', ".column("account", "s")." = '' WHERE ".column("account", "username")." = ?", array($newPassword, $username));
		}
		else
		{
			return false;
		}
	}
	
	public function getKey($key)
	{
		if($key)
		{
			$query = $this->db->query("SELECT recoverykey, username FROM password_recovery_key WHERE recoverykey = ?", array($key));
			$result = $query->result_array();
			if($result[0]['recoverykey'] == $key)
			{
				return $result[0]['username'];
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function insertKey($key, $username, $ip)
	{
		if($key && $ip && $username)
		{
			$this->db->query("INSERT INTO password_recovery_key VALUES (?, ?, ?, ?)", array($key, $username, $ip, time()));
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function deleteKey($key)
	{
		if($key)
		{
			$this->db->query("DELETE FROM password_recovery_key WHERE recoverykey = ?", array($key));
			
			return true;
		}
		else
		{	
			return false;
		}
	}
}

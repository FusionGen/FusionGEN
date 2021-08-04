<?php

class Password_recovery_model extends CI_Model
{

	public function getUsername($email){
		if(!$email)
		{
			return false;
		}
		else
		{
			$query = $this->external_account_model->getConnection()->query("SELECT ".column("account", "username")." FROM ".table("account")." WHERE ".column("account", "email"). "= ?", array($email));
	
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();
				return $result[0]['username'];
			}
			else 
			{
				return false;	
			}
		}
	}

	public function getEmail($username)
	{
		if(!$username)
			return false;

		$query = $this->external_account_model->getConnection()->query(sprintf('SELECT %s FROM %s WHERE %s = ?',
			column('account', 'email'), table('account'), column('account', 'username')), [$username]);

		if(!$query->num_rows())
			return false;

		return $query->row()->email;
	}

	public function changePassword($username, $newPassword)
	{
		if(!$username || !$newPassword)
			return false;

		if(column('account', 'v') && column('account', 's') && column('account', 'sessionkey')) // old emulators only
			$this->external_account_model->getConnection()->set(column('account', 'sessionkey'), '')
				->set(column('account', 's'), '')->set(column('account', 'v'), '');

		$this->external_account_model->getConnection()->set(column('account', 'password'), $newPassword)
			->where(column('account', 'username'), $username)->update(table('account'));
	}

	public function getKey($key)
	{
		if(!$key)
			return false;

		return current($this->db->query('SELECT username FROM password_recovery_key WHERE recoverykey = ?', [$key])->row());
	}

	public function insertKey($key, $username, $ip)
	{
		if(!$key || !$ip || !$username)
			return false;

		$this->db->query('INSERT INTO password_recovery_key VALUES(?, ?, ?, ?)', [$key, $username, $ip, time()]);
		return true;
	}

	public function deleteKey($key)
	{
		if(!$key)
			return false;

		$this->db->query('DELETE FROM password_recovery_key WHERE recoverykey = ?', [$key]);
		return true;
	}
}

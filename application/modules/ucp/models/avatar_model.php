<?php

class Avatar_model extends CI_Model
{
	public function setAvatar($avatar)
	{
		$this->db->update('account_data', $avatar, array('id' => $this->user->getId()));
	}
} 
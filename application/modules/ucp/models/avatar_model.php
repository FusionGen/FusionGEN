<?php

class Avatar_model extends CI_Model
{
	public function setAvatar($avatar)
	{	
		$avatar = array_shift($avatar);
		$this->db->update('account_data',array('avatar' =>$avatar['file_name']), array('id' => $this->user->getId()));
	}
} 


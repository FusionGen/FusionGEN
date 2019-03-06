<?php

class Settings_model extends CI_Model
{
	public function saveSettings($values)
	{
		$this->db->update('account_data', $values, array('id' => $this->user->getId()));
	}
}
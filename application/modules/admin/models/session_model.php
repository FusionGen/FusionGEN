<?php

class Session_model extends CI_Model
{
	public function get()
	{
		$time = time() - 60*5;
		$query = $this->db->query("SELECT DISTINCT ip_address,user_agent,user_data,last_activity FROM ci_sessions WHERE last_activity > ?", array($time));

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
}
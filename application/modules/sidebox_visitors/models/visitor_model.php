<?php

class Visitor_model extends CI_Model
{
	private $db;
	
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database("cms", true);
	}

	public function get()
	{
		$time = time() - 60*5;
		$query = $this->db->query("SELECT DISTINCT ip_address,user_agent,user_data,last_activity FROM ci_sessions WHERE last_activity > ? AND user_data != ''", array($time));

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function getCount()
	{
		$time = time() - 60*5;
		$query = $this->db->query("SELECT COUNT(DISTINCT ip_address,user_agent,user_data,last_activity) AS `total` FROM ci_sessions WHERE last_activity > ?", array($time));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['total'];
		}
		else
		{
			return false;
		}
	}

	public function getGuestCount()
	{
		$time = time() - 60*5;
		$query = $this->db->query("SELECT COUNT(DISTINCT ip_address,user_agent,user_data,last_activity) AS `total` FROM ci_sessions WHERE last_activity > ? AND user_data=''", array($time));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['total'];
		}
		else
		{
			return false;
		}
	}
}

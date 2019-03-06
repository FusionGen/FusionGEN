<?php

class Shoutbox_model extends CI_Model
{
	private $db;
	
	public function __construct()
	{
		parent::__construct();

		$this->db = $this->load->database("cms", true);
	}
	
	public function getShouts($start, $end)
	{
		$this->db->select('*')->from('shouts')->order_by('id', 'DESC')->limit($end, $start);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else 
		{
			return array();	
		}
	}

	public function getCount()
	{
		$this->db->select('COUNT(*) as `total`')->from('shouts');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['total'];
		}
		else 
		{
			return 0;	
		}
	}
	
	public function insertShout($content)
	{
		$data = array(
			'author' => $this->user->getId(), 
			'content' => $content, 
			'date' => time(),
			'is_gm' => hasPermission("shoutAsStaff", "sidebox_shoutbox")
		);
					  
		$this->db->insert('shouts', $data);
	}

	public function deleteShout($id)
	{
		$this->db->query("DELETE FROM shouts WHERE id=?", array($id));
	}
}

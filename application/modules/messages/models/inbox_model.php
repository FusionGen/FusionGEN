<?php

class inbox_model extends CI_Model
{
	private $inbox = false;
	private $sent = false;

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getMessages($userId, $start = 0, $limit = 1)
	{
		$this->db->select('*')->from('private_message')->where(array('user_id' => $userId, 'deleted_user' => 0))->order_by('time', 'DESC')->limit($limit, $start);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result;
		}
		else 
		{
			return false;	
		}
	}
	
	public function countMessages($userId)
	{
		if($this->inbox === false)
		{
			$this->db->select('COUNT(*)')->from('private_message')->where(array('user_id' => $userId, 'deleted_user' => 0));
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();
				$this->inbox = $result[0]['COUNT(*)'];

				return $result[0]['COUNT(*)'];
			}
			else
			{
				$this->inbox = 0;
				return false;
			}	
		}
		else
		{
			return $this->inbox;
		}
	}

	public function getSent($userId, $start = 0, $limit = 1)
	{
		$this->db->select('*')->from('private_message')->where(array('sender_id' => $userId, 'deleted_sender' => 0))->order_by('time', 'DESC')->limit($limit, $start);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result;
		}
		else 
		{
			return false;	
		}
	}
	
	public function countSent($userId)
	{
		if($this->sent === false)
		{
			$this->db->select('COUNT(*)')->from('private_message')->where(array('sender_id' => $userId, 'deleted_sender' => 0));
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result_array();
				$this->sent = $result[0]['COUNT(*)'];
				return $result[0]['COUNT(*)'];
			}
			else
			{
				$this->sent = 0;
				return false;
			}
		}
		else
		{
			return $this->sent;
		}
	}

	public function clear($id, $sent = false)
	{
		if($sent)
		{
			$this->db->query("UPDATE private_message SET deleted_sender=1 WHERE sender_id=?", array($id));
		}
		else
		{
			$this->db->query("UPDATE private_message SET deleted_user=1, `read`=1 WHERE user_id=?", array($id));
		}

		$this->cache->delete("messages/".$this->user->getId()."_*");
	}

	public function clearDeleted($id)
	{
		$this->db->query("DELETE FROM private_message WHERE deleted_user=1 AND deleted_sender=1 AND (user_id=? OR sender_id=?)", array($id, $id));
	}
}

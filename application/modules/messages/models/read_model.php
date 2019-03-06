<?php

class Read_model extends CI_Model
{
	public function reply($user_id, $sender_id, $title, $message)
	{
		$this->db->query("INSERT INTO private_message (`user_id`, `sender_id`, `message`, `time`, `title`) VALUES (?, ?, ?, ?, ?)", array($user_id, $sender_id, $message, time(), $title));
	}

	public function getMessages($id)
	{
		$query = $this->db->query("SELECT * FROM private_message WHERE id = ? AND (sender_id = ? OR user_id = ?) LIMIT 1", array($id, $this->user->getId(), $this->user->getId()));
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			$result = $result[0];

			$query2 = $this->db->query("SELECT * FROM `private_message` WHERE (sender_id=? AND user_id=?) OR (sender_id=? AND user_id=?) ORDER BY `time` DESC LIMIT 5", array($result['sender_id'], $result['user_id'], $result['user_id'], $result['sender_id']));
			$result2 = $query2->result_array();

			// We want the newest on the bottom
			$result2 = array_reverse($result2);

			return $result2;
		}
		else 
		{
			return false;	
		}
	}

	public function markRead($user, $sender)
	{
		$this->db->query("UPDATE private_message SET `read`=1 WHERE user_id=? AND sender_id=?", array($user, $sender));
	}

	public function getLastTitle($id)
	{
		$this->db->select('title')->from('private_message')->where(array('sender_id' => $id))->order_by("id", "desc")->limit(1);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result[0]['title'];
		}
		else 
		{
			return "Unknown sender";	
		}
	}
}
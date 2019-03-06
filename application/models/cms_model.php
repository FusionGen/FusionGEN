<?php

/**
 * @package FusionCMS
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class Cms_model extends CI_Model
{
	private $db;

	/**
	 * Connect to the database
	 */
	public function __construct()
	{
		parent::__construct();

		$this->db = $this->load->database("cms", true);

		$this->logVisit();
		$this->clearSessions();
	}

	private function logVisit()
	{
		if(!$this->input->is_ajax_request() && !isset($_GET['is_json_ajax']))
		{
			$this->db->query("INSERT INTO visitor_log(`date`, `ip`) VALUES(?, ?)", array(date("Y-m-d"), $this->input->ip_address()));
		}

		$session = array(
			'ip_address' => $this->input->ip_address(),
			'user_agent' => substr($this->input->user_agent(), 0, 120),
		);

		$this->db->where('ip_address', $session['ip_address']);
		$this->db->where('user_agent', $session['user_agent']);

		$query = $this->db->get("ci_sessions");
		
		$data = array(
			"ip_address" => $session['ip_address'],
			"user_agent" => $session['user_agent'],
			"last_activity" => time(),
			"user_data" => ""
		);

		if($this->session->userdata('online'))
		{
			$udata = array(
				'id' => $this->session->userdata('id'),
				'nickname' => $this->session->userdata('nickname'),
			);

			$data['user_data'] = serialize($udata);
		}

		if($query->num_rows() == 0)
		{
			$data['session_id'] = uniqid(time());
			$this->db->insert("ci_sessions", $data);
		}
		else
		{
			$this->db->where('ip_address', $session['ip_address']);
			$this->db->where('user_agent', $session['user_agent']);
			$this->db->update("ci_sessions", $data);
		}
	}

	private function clearSessions()
	{
		$this->db->query("DELETE FROM ci_sessions WHERE last_activity < ?", array(time() - 60*60));
	}

	public function getModuleConfigKey($moduleId, $key)
	{
		$query = $this->db->query("SELECT m.id, m.module_id, m.key, m.value, m.date_added, m.date_changed FROM modules_configs m WHERE m.module_id = ? AND m.key = ?", array((int)$moduleId, (string)$key));

		// Return results
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result[0];
		}

		return null;
	}

	public function getSideboxes()
	{
		$query = $this->db->query("SELECT * FROM sideboxes ORDER BY `order` ASC");
		
		return $query->result_array();
	}

	/**
	 * Load the slider images
	 * @return Array
	 */
	public function getSlides()
	{
		$query = $this->db->query("SELECT * FROM image_slider ORDER BY `order` ASC");

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}

		return null;
	}

	/**
	 * Get the links of one direction
	 * @param Int $side ID of the specific menu
	 * @return Array
	 */
	public function getLinks($side = "top")
	{
		if(in_array($side, array("top", "side")))
		{
			$query = $this->db->query("SELECT * FROM menu WHERE side = ? ORDER BY `order` ASC", array($side));
		}
		else
		{
			$query = $this->db->query("SELECT * FROM menu ORDER BY `order` ASC", array($side));
		}

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}

		return null;
	}
	
	/**
	 * Get the selected page from the database
	 * @param String $page
	 * @return Array 
	 */
	public function getPage($page)
	{
		$this->db->select('*')->from('pages')->where('identifier', $page);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result[0];
		}

		return null;
	}

	/**
	 * Get any old rank ID (to avoid foreign key errors)
	 * @return Int 
	 */
	public function getAnyOldRank()
	{
		$query = $this->db->query("SELECT id FROM `ranks` ORDER BY id ASC LIMIT 1");

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result[0]['id'];
		}

		return false;
	}
	
	/**
	 * Get all pages
	 * @return Array
	 */
	public function getPages()
	{
		$this->db->select('*')->from('pages');
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result;
		}

		return null;
	}

	/**
	 * Get all data from the realms table
	 * @return Array
	 */
	public function getRealms()
	{
		$this->db->select('*')->from('realms');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result;
		}

		return null;
	}

	/**
	 * Get the realm database information
	 * @param Int $id
	 * @return Array
	 */
	public function getRealm($id)
	{
		$this->db->select('*')->from('realms')->where('id', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result[0];
		}

		return null;
	}

	/**
	 * Get the amount of unread messages
	 * @return Int
	 */
	public function getMessagesCount()
	{
		$this->db->select('COUNT(*) as `total`')->from('private_message')->where(array('user_id' => $this->user->getId(), 'read' => 0));
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();

			return $result[0]['total'];
		}

		return 0;
	}
}
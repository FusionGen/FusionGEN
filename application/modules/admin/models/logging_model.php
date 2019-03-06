<?php
/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @link http://fusion-hub.com
 */
class Logging_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Find logs by the given parameters
	 * @param $search
	 * @param $module
	 * @return bool
	 */
	public function findLogs($search = "", $module = "")
	{
		if(!empty($search))
		{
			if(!is_numeric($search))
			{
				$userId = $this->user->getId($search);
			}
			else
			{
				$userId = $search;
			}
		}

		if($search)
		{
			$query = $this->db->query("SELECT * FROM `logs` WHERE ".(($module) ? "`module` = '".$module."' AND " : "")." (`user` = ? OR `ip` = ?)", array($userId, $search));
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `logs` ".(($module) ? "WHERE `module` = '".$module."'" : ""));
		}


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
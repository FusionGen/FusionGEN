<?php

/**
 * @package FusionCMS
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class Logger_model extends CI_Model
{
	public function getLogsDb($logType = "", $offset = 0, $limit = 0)
	{
		if(($logType != "" && !is_string($logType)) || !is_numeric($limit) || !is_numeric($offset))
			return null;

		$this->db->select('id, module, logType, logMessage, user, ip, custom, time');
		if ($logType != "") $this->db->where('logType', $logType);
		$this->db->order_by('time', 'DESC');
		if ($limit > 0 && $offset == 0) $this->db->limit($limit);
		if ($limit > 0 && $offset > 0) $this->db->limit(($offset + $limit), $offset);
		$query = $this->db->get('logs');

		// Get the results
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return null;
		}
	}

	public function getLogCount()
	{
		$this->db->select("COUNT(id) 'count'");
		$query = $this->db->get('logs');

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			return $result[0]['count'];
		}
	}

	public function createLogDb($moduleName, $logType, $logMessage, $user, $ip)
	{
		$this->db->query("INSERT INTO `logs` (`module`, `logType`, `logMessage`, `user`, `ip`, `time`) VALUES (?, ?, ?, ?, ?, ?)", array($moduleName, $logType, $logMessage, $user, $ip, time()));
	}
}

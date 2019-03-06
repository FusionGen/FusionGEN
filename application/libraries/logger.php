<?php

/**
 * @package FusionCMS
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class Logger
{
	private $CI;

	public function __construct()
	{
		//Get the instance of the CI
		$this->CI = &get_instance();

		// Load the logger model
		$this->CI->load->model('logger_model');
	}

	/**
	 * Get all the logs by type and limit
	 * @param null $type
	 * @param int $limit
	 * @return mixed
	 */
	public function getLogs($type = "", $offset = 0, $limit = 0)
	{
		return $this->CI->logger_model->getLogsDb($type, $offset, $limit);
	}

	/**
	 * Create a new log with the given message and with or without type and modulename,
	 * will use the current module if not set.
	 * @param $message
	 * @param string $type
	 * @param string $moduleName
	 */
	public function createLog($type, $message, $moduleName = "")
	{
		// If no module name was given get the current one.
		if(empty($moduleName))
		{
			$moduleName = $this->CI->template->getModuleName();
		}

		$userId = 0;

		if($this->CI->user->isOnline())
		{
			$userId = $this->CI->user->getId();
		}

		// Call our model and add to the db.
		$this->CI->logger_model->createLogDb($moduleName, $type, $message, $userId, $this->CI->input->ip_address());
	}

	/**
	 * Get the number of logs.
	 * @return mixed
	 */
	public function getLogCount()
	{
		return $this->CI->logger_model->getLogCount();
	}
}

<?php

require_once(dirname(__FILE__).'/trinity_rbac_cata_soap.php');

/**
 * Abstraction layer for supporting different emulators
 */

class Trinity_rbac_cata_ra extends Trinity_rbac_cata_soap implements Emulator
{	
	/**
	 * The telnet socket
	 */
	protected $telnetSocket;
	
	/**
	 * The buffer for telnet
	 */
	protected $telnetBuffer;

	/**
	 * Send a console command
	 * @param String $command
	 * @return Array
	 */
	public function send($command)
	{
		//Open the telnet Connection
		$this->telnetOpen($this->config['hostname'], $this->config['console_port']);
		$this->telnetBuffer = $this->telnetReadOutput();
		
		//Login on telnet
		$this->telnetLogin($this->config['console_username'], $this->config['console_password']);
		$this->telnetBuffer = $this->telnetReadOutput();
		
		//Send command in telnet
		$this->telnetWrite($command);
		$this->telnetBuffer = $this->telnetReadOutput();

	}

	public function telnetReadOutput()
	{
		return fgets($this->telnetSocket, 1024);
	}

	public function telnetOpen($ip, $port)
	{
		$connection = $this->telnetSocket = @fsockopen($ip, $port, $errno, $errstr, 5);
		
		if($connection)
		{
			return true;
		}
		else
		{
			die("Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br /><br /><b>Error:</b> <br />".$errstr);

			return false;
		}
	}
	
	public function telnetLogin($username, $password)
	{
		$this->telnetWrite($username);
		$this->telnetWrite($password);
	}
	
	public function telnetWrite($string)
	{
		try
		{
			fwrite($this->telnetSocket, $string."\n");
		}
		catch(Exception $e)
		{
			die("Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br /><br /><b>Error:</b> <br />".$errstr);
		}

		$this->telnetSleep();	
	}

	public function telnetSleep() 
    {
        sleep(3);

        return;
    }
}
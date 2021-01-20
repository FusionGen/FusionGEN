<?php defined('BASEPATH') OR die('Silence is golden.');

/**
 * @package FusionCMS
 * @version 6.x
 * @link    https://code-path.com
 * @copyright (c) 2020 Code path web developing team
 */

require_once __DIR__ . '/trinity_rbac_soap.php';

/**
 * Abstraction layer for supporting different emulators
 */
class Trinity_rbac_ra extends Trinity_rbac_soap implements Emulator
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
        // Open the telnet Connection
        $this->telnetOpen($this->config['hostname'], $this->config['console_port']);
        $this->telnetBuffer = $this->telnetReadOutput();

        // Login on telnet
        $this->telnetLogin($this->config['console_username'], $this->config['console_password']);
        $this->telnetBuffer = $this->telnetReadOutput();

        // Send command in telnet
        $this->telnetWrite($command);
        $this->telnetBuffer = $this->telnetReadOutput();
    }

    public function telnetReadOutput()
    {
        return fgets($this->telnetSocket, 1024);
    }

    public function telnetOpen($ip, $port)
    {
        $this->telnetSocket = @fsockopen($ip, $port, $errno, $errstr, 5);

        if($this->telnetSocket)
            return true;

        die('Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br/><br/>
            <b>Error:</b> <br/>' . $errstr); // @note this is not dev friendly and make impossible to catch the error
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
            fwrite($this->telnetSocket, $string . PHP_EOL);
        }
        catch(Exception $e)
        {
            die('Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br/><br/>
                <b>Error:</b> <br/>' . $errstr); // @note this is not dev friendly and make impossible to catch the error
        }

        $this->telnetSleep();
    }

    public function telnetSleep()
    {
        sleep(3);
    }
}

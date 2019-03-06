<?php

interface Emulator {}

class Auth
{
	public static $db;
	public static $emulatorName;
	public static $emulator;

	public static function initialize()
	{
		self::connect();

		$query = Update::$db->query("SELECT emulator FROM realms ORDER BY id ASC LIMIT 1");
		
		if($query->num_rows)
		{
			$result = $query->fetch_array(MYSQLI_ASSOC);

			self::$emulatorName = $result['emulator'];

			// Make sure the emulator is installed
			if(file_exists('../application/emulators/'.self::$emulatorName.'.php'))
			{
				require_once('../application/emulators/'.self::$emulatorName.'.php');
			}
			else
			{
				die("The entered emulator (".self::$emulatorName.") doesn't exist in application/emulators/");
			}

			// Pass the realm ID to the emulator layer
			$config['id'] = 1;

			// Initialize the objects
			self::$emulator = new self::$emulatorName($config);
		}
		else
		{
			die("There are no realms");
		}
	}

	private static function connect()
	{
		require("../application/config/database.php");

		$port = (array_key_exists("port", $db['account'])) ? $db['account']['port'] : false;

		self::$db = new mysqli($db['account']['hostname'], $db['account']['username'], $db['account']['password'], $db['account']['database'], $port);
	}
}

Auth::initialize();
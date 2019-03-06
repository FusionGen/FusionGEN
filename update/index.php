<?php

/**
 * Update system
 * @package FusionCMS
 */

class UpdaterException extends Exception {}

class Update
{
	public static $currentVersion;
	public static $latestVersion;
	public static $updates;
	public static $db;
	private static $password;
	private static $viewData = array();

	/**
	 * Initialize all necessary components
	 */
	public static function initialize()
	{
		self::connect();
		self::getPassword();

		session_start();

		self::getCurrentVersion();

		if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== self::$password)
		{
			self::login();
		}
		else
		{
			self::getLatestVersion();

			// perform update action?
			if(isset($_GET['action']) && isset($_GET['version']))
			{
				$version = $_GET['version'];
				$action = $_GET['action'];

				if($action == 'install')
				{
					try {
						if (self::hasSql($version))
							self::insertSqls($version);
						
						self::installFiles($version);
					}
					catch (UpdaterException $e) {
						self::$viewData['error_msg'] = $e->getMessage();
					}
					
					self::main();
				}
				elseif($action == 'import') {
					
				}
				elseif(self::toolExists($version, $action))
				{
					$tool = self::getTool($version, $action);

					self::main($tool);
				}
				else
				{
					die("Invalid action");
				}
			}
			else
			{
				// display available updates
				self::getAvailableUpdates();
				self::main();
			}
		}
	}

	private static function connect()
	{
		require("../application/config/database.php");

		$port = (array_key_exists("port", $db['cms'])) ? $db['cms']['port'] : false;

		self::$db = new mysqli($db['cms']['hostname'], $db['cms']['username'], $db['cms']['password'], $db['cms']['database'], $port);
	}

	/**
	 * Query all SQL files in an update
	 * @param String $version
	 */
	private static function insertSqls($version)
	{
		$version = str_replace('.', '_', $version);
		$sqls = glob("updates/".$version."/sql/*.sql");

		foreach($sqls as $sql)
		{
			self::splitSQL($sql);
		}
	}
	
	/**
	 * Installs the file changes of an update package
	 * @param string $version
	 */
	private static function installFiles($version)
	{
		$path = 'updates/'.str_replace('.', '_', $version).'/';

		// remove deleted files
		if (file_exists($path.'deleted_files.txt')) 
		{
			$files = file($path.'deleted_files.txt');
			
			foreach ($files as $file) {
				@unlink('../'.$file);
			}
		}
		
		// install zips
		$zips = self::getZips($path);
		
		if ($zips)
		{
			foreach ($zips as $file) 
			{
				$zip = new ZipArchive();
			
				if ($zip->open($file) !== true)
					throw new UpdaterException('Could not open zip archive: '.$file);
			
				if ($zip->extractTo(realpath('../')) !== true)
					throw new UpdaterException('Zip extraction failed: '.$file);
			
				$zip->close();
			}
		}
	}

	/**
	 * Get a tool class
	 * @param String $version
	 * @param String $toolName
	 */
	private static function getTool($version, $toolName)
	{
		$version = preg_replace("/\./", "_", $version);
		
		require_once("updates/".$version."/tools/".$toolName."/".$toolName.".php");

		$toolName = ucfirst($toolName);

		$tool = new $toolName();

		return $tool;
	}

	private static function splitSQL($file, $delimiter = ';')
	{
		set_time_limit(0);

		if(is_file($file) === true)
		{
			$file = fopen($file, 'r');

			if(is_resource($file) === true)
			{
				$query = array();

				while(feof($file) === false)
				{
					$query[] = fgets($file);

					if(preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
					{
						$query = trim(implode('', $query));

						if(!self::$db->query($query))
						{
							throw new UpdaterException('Database error: '.self::$db->error);
						}

						while(ob_get_level() > 0)
						{
							ob_end_flush();
						}

						flush();
					}

					if(is_string($query) === true)
					{
						$query = array();
					}
				}

				return fclose($file);
			}
		}

		return false;
	}

	/**
	 * Check for a specific tool in a specific version
	 * @param String $version
	 * @param String $toolName
	 */
	private static function toolExists($version, $toolName)
	{
		$version = preg_replace("/\./", "_", $version);

		if(is_dir("updates/".$version)
		&& is_dir("updates/".$version."/tools/")
		&& file_exists("updates/".$version."/tools/".$toolName."/".$toolName.".php"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check if a specific version has SQL files
	 * @param String $version
	 */
	private static function hasSql($version)
	{
		$version = preg_replace("/\./", "_", $version);

		if(is_dir("updates/".$version) && is_dir("updates/".$version."/sql/"))
		{
			$sqls = glob("updates/".$version."/sql/*.sql");

			if(count($sqls))
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Display a view file
	 * @param String $file
	 * @param Array $data
	 */
	public static function getView($file, $data = false)
	{
		if(file_exists($file))
		{
			if($data)
			{
				extract($data);
			}

			ob_start();

			include($file);

			return ob_get_clean();
		}
	}

	/**
	 * Load the password file or create it
	 */
	private static function getPassword()
	{
		if(file_exists("update_password.php"))
		{
			require_once("update_password.php");
		}
		else
		{
			if(!is_writable("./"))
			{
				die('The updates/ folder is not writable. Please see <a href="https://raxezdev.zendesk.com/entries/22839206-File-permissions-Installation-problems-fopen-permission-denied-" target="_blank">the FAQ</a> for more information.');
			}

			$file = fopen("update_password.php", "w");

			$password = uniqid().uniqid().uniqid().uniqid();

			fwrite($file, '<?php $password = "'.$password.'";');
			fclose($file);
		}

		self::$password = $password;
	}

	/**
	 * Show the main page and handle requests
	 */
	private static function main($tool = false)
	{
		if($tool)
		{
			self::$viewData['tool'] = $tool;
		}

		echo self::getView("views/main.php", self::$viewData);
	}

	/**
	 * Returns true if $a >= $b
	 * @param String $a
	 * @param String $b
	 * @return Boolean
	 */
	public function compareVersions($a, $b)
	{
		$maxLength = 4;

		$a = preg_replace("/\./", "", $a);
		$b = preg_replace("/\./", "", $b);

		// Add ending zeros if necessary
		if(strlen($a) < $maxLength)
		{

			for($i = 0; $i <= ($maxLength - strlen($a)); $i++)
			{
				$a .= "0";
			}
		}

		// Add ending zeros if necessary
		if(strlen($b) < $maxLength)
		{
			for($i = 0; $i <= ($maxLength - strlen($b)); $i++)
			{
				$b .= "0";
			}
		}

		return (int)$a >= (int)$b;
	}

	/**
	 * Show the log in view and handle log in requests
	 */
	private static function login()
	{
		$data = false;

		if(isset($_POST['password']))
		{
			if($_POST['password'] == self::$password)
			{
				// Signed in!
				$_SESSION['auth'] = self::$password;

				// Refresh
				header("Location: ./");
			}
			else
			{
				$data = array('wrongPassword' => true);
			}
		}

		echo self::getView("views/login.php", $data);
	}

	/**
	 * Get the currently installed version
	 */
	private static function getCurrentVersion()
	{
		require_once("../application/config/version.php");

		if(array_key_exists("v", $config))
		{
			self::$currentVersion = $config['v'];
		}
		elseif(array_key_exists("FusionCMSVersion", $config))
		{
			self::$currentVersion = $config['FusionCMSVersion'];
		}
		else
		{
			self::$currentVersion = false;
		}
	}

	/**
	 * Get the latest version available
	 */	
	private static function getLatestVersion()
	{
		try
		{
			$version = file_get_contents("http://fusion-hub.com/remote/latestVersion");
		}
		catch(Exception $e)
		{
			$version = false;
		}

		self::$latestVersion = $version;
	}

	/**
	 * Get all the versions that are in updates/*
	 */
	private static function getAvailableUpdates()
	{
		self::$updates = array();

		$updates = glob("updates/*/");

		if($updates)
		{
			foreach($updates as $path)
			{
				if(is_dir($path))
				{
					$version = preg_replace("/[a-z\/]*/i", "", $path);
					$version = preg_replace("/_/", ".", $version);

					self::$updates[$version] = array(
						"sql" => self::getSqls($path),
						"tools" => self::getTools($path),
						"zip" => self::getZips($path),
						"changelog" => (file_exists($path."index.html")) ? file_get_contents($path."index.html") : "",
						"instructions" => (file_exists($path."instructions.html")) ? file_get_contents($path."instructions.html") : ""
					);
				}
			}

			self::$updates = array_reverse(self::$updates);
		}
	}
	
	/**
	 * Get the SQLs for the specific update path
	 * @param String $path
	 * @return Array
	 */
	private static function getSqls($path)
	{
		if(file_exists($path."sql/"))
		{
			return glob($path."sql/*.sql");
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * Get the tools for the specific update path
	 * @param String $path
	 * @return Array
	 */	
	private static function getTools($path)
	{
		if(file_exists($path."tools/"))
		{
			$tools = array();

			$found = glob($path."tools/*/");

			foreach($found as $toolPath)
			{
				if(is_dir($toolPath))
				{
					$name = preg_replace("/updates\/[0-9_]+\/tools\/([a-z0-9-_]*)\//i", "$1", $toolPath);

					$tools[$toolPath] = $name;
				}
			}

			return $tools;
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * Get the zips for the specific update path
	 * @param String $path
	 * @return Array
	 */	
	private static function getZips($path)
	{
		if(file_exists($path."zip/"))
		{
			return glob($path."zip/*.zip");
		}
		else
		{
			return array();
		}
	}

}

Update::initialize();
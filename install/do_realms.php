<?php
class Realms
{
	private $db;
	public function __construct()
	{
		if(isset($_GET['step']))
		{
			switch($_GET['step'])
			{
				case "getEmulators": $this->getEmulators(); break;
			}
		}

		if (isset($_POST)) {
			$hostname = $_POST["hostname"];
			$username = $_POST["username"];
			$password = $_POST["password"];
			$db_port = $_POST["db_port"];
			$characters = $_POST["characters"];
			$world = $_POST["world"];
			$cap = $_POST["cap"];
			$realmName = $_POST["realmName"];
			$console_username = $_POST["console_username"];
			$console_password = $_POST["console_password"];
			$console_port = $_POST["console_port"];
			$emulator = $_POST["emulator"];
			$realm_port = $_POST["realm_port"];
		
			if (!($hostname && $username && $characters && $world && $cap && $realmName && $console_username && $console_password && $console_port && $realm_port)) {
				echo json_encode(array("success" => false, "message" => "Please input all fields."));
				exit();
			}

			require('../application/config/database.php');
			
			$mysqli = new mysqli($db['cms']['hostname'], $db['cms']['username'], $db['cms']['password'], $db['cms']['database'], $db['cms']['port']);
			$mysqli_characters = @new mysqli($hostname, $username, $password, $characters);
			$mysqli_world = @new mysqli($hostname, $username, $password, $world);

			if (!mysqli_select_db($mysqli_characters, $characters)) {
				echo json_encode(array("success" => false, "message" => "Looks like your characters database doesn't exist"));
				exit();
			}

			if (!mysqli_select_db($mysqli_world, $world)) {
				echo json_encode(array("success" => false, "message" => "Looks like your world database doesn't exist"));
				exit();
			}
			
			$query = ("INSERT INTO realms(`id`, `hostname`, `username`, `password`, `char_database`, `world_database`, `cap`, `realmName`, `console_username`, `console_password`, `console_port`, `emulator`, `realm_port`, `override_port_world`, `override_username_world`, `override_password_world`, `override_hostname_world`, `override_port_char`, `override_username_char`, `override_password_char`, `override_hostname_char`)
					  VALUES('?',
							 '".$hostname."',
					  		 '".$username."',
					  		 '".$password."',
					  		 '".$characters."',
					  		 '".$world."',
					  		 '".$cap."',
					  		 '".$realmName."',
					  		 '".$console_username."',
					  		 '".$console_password."',
					  		 '".$console_port."',
					  		 '".$emulator."',
					  		 '".$realm_port."',
					  		 '".$db_port."',
					  		 '".$username."',
							 '".$password."',
							 '".$hostname."',
							 '".$db_port."',
							 '".$username."',
							 '".$password."',
							 '".$hostname."');");

			if(mysqli_query($mysqli, $query)){
				echo json_encode(array("success" => true));
				exit();
			} else {
				echo json_encode(array("success" => false, "message" => mysqli_error($mysqli))); 
			}
		}
	}

	private function getEmulators()
	{
		require_once("../application/config/emulator_names.php");
		die(json_encode($emulators));
	}

	private function realms()
	{
		$this->connect();

		$realms = json_decode(stripslashes($_POST['realms']), true);
		
		if(is_array($realms))
		{
			foreach($realms as $realm)
			{
				$this->db->query("INSERT INTO realms(`hostname`, `username`, `password`, `char_database`, `world_database`, `cap`, `realmName`, `console_username`, `console_password`, `console_port`, `emulator`, `realm_port`, `override_port_world`, `override_username_world`, `override_password_world`, `override_hostname_world`, `override_port_char`, `override_username_char`, `override_password_char`, `override_hostname_char`)
							VALUES('".$this->db->real_escape_string($realm['emulator'])."',
									'".$this->db->real_escape_string($realm['cap'])."',
									'".$this->db->real_escape_string($realm['characters'])."',
									'".$this->db->real_escape_string($realm['console_password'])."',
									'".$this->db->real_escape_string($realm['console_port'])."',
									'".$this->db->real_escape_string($realm['console_username'])."',
									'".$this->db->real_escape_string($realm['hostname'])."',
									'".$this->db->real_escape_string($realm['password'])."',
									'".$this->db->real_escape_string($realm['port'])."',
									'".$this->db->real_escape_string($realm['realmName'])."',
									'".$this->db->real_escape_string($realm['username'])."',
									'".$this->db->real_escape_string($realm['world'])."',
									'".$this->db->real_escape_string($realm['db_port'])."',
									'".$this->db->real_escape_string($realm['db_port'])."')");
			}
		}
	}

	private function finalStep()
	{
		$file = fopen('.lock', 'w');
		fclose($file);
		
		if(file_exists(".lock"))
		{
			die('success');
		}
	}
}

$realms = new Realms();

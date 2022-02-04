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
            $mysqli_characters = @new mysqli($hostname, $username, $password, $characters, $db_port);
            $mysqli_world = @new mysqli($hostname, $username, $password, $world, $db_port);

            if (!mysqli_select_db($mysqli_characters, $characters)) {
                echo json_encode(array("success" => false, "message" => "Looks like your characters database doesn't exist"));
                exit();
            }

            if (!mysqli_select_db($mysqli_world, $world)) {
                echo json_encode(array("success" => false, "message" => "Looks like your world database doesn't exist"));
                exit();
            }

            $query = ("INSERT INTO realms(`hostname`, `username`, `password`, `char_database`, `world_database`, `cap`, `realmName`, `console_username`, `console_password`, `console_port`, `emulator`, `realm_port`, `override_port_world`, `override_username_world`, `override_password_world`, `override_hostname_world`, `override_port_char`, `override_username_char`, `override_password_char`, `override_hostname_char`)
                        VALUES(
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
}

$realms = new Realms();

<?php
ini_set('max_execution_time', 30);
include('../application/config/database.php');

if(isset($_POST)) {
    $accname = $_POST['accname'];

    if (!$accname) {
    echo json_encode(array("success" => false, "message" => "Please input your account name"));
    exit();
    }

    global $db;

    try {
        $mysqli_auth = new mysqli($db['account']['hostname'], $db['account']['username'], $db['account']['password'], $db['account']['database'], $db['account']['port']);
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Auth DB: ".$e->getMessage()));
        exit();
	}

    try {
        $query = mysqli_query($mysqli_auth, "SELECT username from account WHERE username = '".$accname."'");
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Auth DB: ".$e->getMessage()));
        exit();
	}

    if(mysqli_num_rows($query) === 0) {
        echo json_encode(array("success" => false, "message" => "Accountname not found!"));
        exit();
    }

    if(file_exists("../application/config/owner.php")) {
        unlink("../application/config/owner.php");
    }

    $owner = fopen("../application/config/owner.php", "w");
    fwrite($owner, '<?php $config["owner"] = "'.addslashes($_POST['accname']).'";');
    fclose($owner);
	
    $file = fopen('.lock', 'w');
    fclose($file);

    if(file_exists(".lock"))
    {
        echo json_encode(array("success" => true));
        exit();
    } else {
        echo json_encode(array("success" => false, "message" => "Not possible to create .lock file, no write permissions?"));
        exit();
    }
}

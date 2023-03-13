<?php

set_time_limit(600);

if(isset($_POST)) {
    $host = $_POST["host"];
    $dbuser = $_POST["dbuser"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];
    $dbport = $_POST["dbport"];
    $auth_host = $_POST["auth_host"];
    $auth_db_user = $_POST["auth_db_user"];
    $auth_db_pass = $_POST["auth_db_pass"];
    $auth_db = $_POST["auth_db"];
    $auth_port = $_POST["auth_port"];

    if (!($host && $dbuser && $dbpassword && $dbname && $auth_host && $auth_db_user && $auth_db_pass && $auth_db))
    {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }

    try {
        $mysqli_fusion = new mysqli($host, $dbuser, $dbpassword, $dbname, $dbport);
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Fusion DB: ".$e->getMessage()));
        exit();
	}

    $result = mysqli_query($mysqli_fusion, "SELECT VERSION() as mysql_version");
    $row = mysqli_fetch_assoc($result);

    $version = $row['mysql_version'];
    if (str_contains($row['mysql_version'], '-'))
    {
        $version = substr($row['mysql_version'], 0, strpos($row['mysql_version'], "-"));
    }

    if (version_compare($version, '5.7.0', '<'))
    {
        echo json_encode(array("success" => false, "message" => "Fusion DB: MySQL server version is too old! Please use at least MySQL 5.7"));
        exit();
    }

    try {
        $mysqli_auth = new mysqli($auth_host, $auth_db_user, $auth_db_pass, $auth_db, $auth_port);
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Auth DB: ".$e->getMessage()));
        exit();
	}

    if (!is_file('SQL/database.sql'))
    {
        echo json_encode(array("success" => false, "message" => "The database.sql file could not be found!"));
        exit();
    }

    if (file_exists("../application/config/database.php"))
    {
        unlink("../application/config/database.php");
    }
    $db = fopen("../application/config/database.php", "w");

    $raw = '<?php
$active_group = "cms";
$query_builder = true;

$db["cms"]["hostname"] = "'.$host.'";
$db["cms"]["username"] = "'.$dbuser.'";
$db["cms"]["password"] = "'.$dbpassword.'";
$db["cms"]["database"] = "'.$dbname.'";
$db["cms"]["port"] 	   = "'.$dbport.'";
$db["cms"]["dbdriver"] = "mysqli";
$db["cms"]["dbprefix"] = "";
$db["cms"]["pconnect"] = false;
$db["cms"]["db_debug"] = true;
$db["cms"]["cache_on"] = false;
$db["cms"]["cachedir"] = "";
$db["cms"]["char_set"] = "utf8mb4";
$db["cms"]["dbcollat"] = "utf8mb4_unicode_ci";
$db["cms"]["swap_pre"] = "";
$db["cms"]["autoinit"] = true;
$db["cms"]["stricton"] = false;

$db["account"]["hostname"] = "'.$auth_host.'";
$db["account"]["username"] = "'.$auth_db_user.'";
$db["account"]["password"] = "'.$auth_db_pass.'";
$db["account"]["database"] = "'.$auth_db.'";
$db["account"]["port"]     = "'.$auth_port.'";
$db["account"]["dbdriver"] = "mysqli";
$db["account"]["dbprefix"] = "";
$db["account"]["pconnect"] = false;
$db["account"]["db_debug"] = true;
$db["account"]["cache_on"] = false;
$db["account"]["cachedir"] = "";
$db["account"]["char_set"] = "utf8mb4";
$db["account"]["dbcollat"] = "utf8mb4_unicode_ci";
$db["account"]["swap_pre"] = "";
$db["account"]["autoinit"] = false;
$db["account"]["stricton"] = false;';

    fwrite($db, $raw);
    fclose($db);

    //start installation
    $sql = file_get_contents("SQL/database.sql");

    try {
        $mysqli_fusion->multi_query($sql);
        do {	}

        while (mysqli_more_results($mysqli_fusion) && mysqli_next_result($mysqli_fusion));
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "message" => "Fusion DB import failed! Error: ".$e->getMessage()));
        exit();
	}

    $mysqli_fusion->close();
    // database created

    echo json_encode(array("success" => true));
    exit();
}
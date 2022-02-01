<?php
if (isset($_POST)) {
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

    if (!($host && $dbuser && $dbname && $auth_host && $auth_db_user && $auth_db_pass && $auth_db)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }

    $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname, $dbport);
    $mysqli_auth = @new mysqli($auth_host, $auth_db_user, $auth_db_pass, $auth_db, $auth_port);

    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
        exit();
    }
	
    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli_auth->connect_error));
        exit();
    }
	
    $mysqli_fusion = @new mysqli($host, $dbuser, $dbpassword, $dbname, $dbport);
    $mysqli_auth = @new mysqli($host, $auth_db_user, $auth_db_pass, $auth_db, $auth_port);

    if (!mysqli_select_db($mysqli_fusion, $dbname)) {
        echo json_encode(array("success" => false, "message" => "Looks like your fusiongen database doesn't exist"));
        exit();
    }

    if (!mysqli_select_db($mysqli_auth, $auth_db)) {
        echo json_encode(array("success" => false, "message" => "Looks like your auth database doesn't exist"));
        exit();
	}

    if (!is_file('SQL/database.sql')) {
        echo json_encode(array("success" => false, "message" => "The database.sql file could not be found!"));
        exit();
    }

    if(file_exists("../application/config/database.php")) {
        unlink("../application/config/database.php");
    }
    $db = fopen("../application/config/database.php", "w");

    $raw = '<?php
$active_group = "cms";
$active_record = TRUE;

$db["cms"]["hostname"] = "'.$host.'";
$db["cms"]["username"] = "'.$dbuser.'";
$db["cms"]["password"] = "'.$dbpassword.'";
$db["cms"]["database"] = "'.$dbname.'";
$db["cms"]["port"] 	   = '.(is_numeric($dbport) ? $dbport : self::MYSQL_DEFAULT_PORT).';
$db["cms"]["dbdriver"] = "mysqli";
$db["cms"]["dbprefix"] = "";
$db["cms"]["pconnect"] = TRUE;
$db["cms"]["db_debug"] = TRUE;
$db["cms"]["cache_on"] = FALSE;
$db["cms"]["cachedir"] = "";
$db["cms"]["char_set"] = "utf8";
$db["cms"]["dbcollat"] = "utf8_general_ci";
$db["cms"]["swap_pre"] = "";
$db["cms"]["autoinit"] = TRUE;
$db["cms"]["stricton"] = FALSE;

$db["account"]["hostname"] = "'.$auth_host.'";
$db["account"]["username"] = "'.$auth_db_user.'";
$db["account"]["password"] = "'.$auth_db_pass.'";
$db["account"]["database"] = "'.$auth_db.'";
$db["account"]["port"]     = '.(is_numeric($auth_port) ? $auth_port : self::MYSQL_DEFAULT_PORT).';
$db["account"]["dbdriver"] = "mysqli";
$db["account"]["dbprefix"] = "";
$db["account"]["pconnect"] = TRUE;
$db["account"]["db_debug"] = TRUE;
$db["account"]["cache_on"] = FALSE;
$db["account"]["cachedir"] = "";
$db["account"]["char_set"] = "utf8";
$db["account"]["dbcollat"] = "utf8_general_ci";
$db["account"]["swap_pre"] = "";
$db["account"]["autoinit"] = FALSE;
$db["account"]["stricton"] = FALSE;';

    fwrite($db, $raw);
    fclose($db);

    //nooby but easy to add more files
    //should we make a select box for item display IDs -> do_realms?

    //start installation
    $sql = file_get_contents("SQL/database.sql");
    $sql2 = file_get_contents("SQL/item_display_335a.sql");
    $mysqli->multi_query($sql);
    do {	} 

    while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));

    $mysqli->multi_query($sql2);
    do {	} 
	
    while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
	
    $mysqli->close();
    // database created

    echo json_encode(array("success" => true));
    exit();
}
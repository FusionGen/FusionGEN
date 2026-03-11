<?php
if (file_exists(".lock"))
{
    header("HTTP/1.1 403 Forbidden");
    exit();
}

if (\function_exists('set_time_limit')) {
    set_time_limit(30);
}

include('../application/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accname']))
    {
        $accname = $_POST['accname'];

        if (empty($accname))
        {
            echo json_encode(["success" => false, "message" => "Please input your account name"]);
            exit();
        }

        global $db;

        try {
            $mysqli_auth = new mysqli($db['account']['hostname'], $db['account']['username'], $db['account']['password'], $db['account']['database'], $db['account']['port']);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Auth DB: ".$e->getMessage()]);
            exit();
        }

        $query = $mysqli_auth->prepare("SELECT username from account WHERE username = ?");
        $query->bind_param("s", $accname);

        try {
            $query->execute();
            $query->store_result();
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Auth DB: ".$e->getMessage()]);
            exit();
        }

        if ($query->num_rows() === 0) {
            echo json_encode(["success" => false, "message" => "Accountname not found!"]);
            exit();
        }

        $query->close();

        $ownerPath = '../application/config/owner.php';

        $ownerConfig = "<?php\n\$config['owner'] = " . var_export($accname, true) . ";\n";

        file_put_contents($ownerPath, $ownerConfig);

        file_put_contents('.lock', '');

        if (file_exists(".lock"))
        {
            echo json_encode(["success" => true]);
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Not possible to create .lock file, no write permissions?"]);
            exit();
        }

    } else {
        echo json_encode(["success" => false, "message" => "Accountname not provided!"]);
        exit();
    }
}

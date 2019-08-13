<style type="text/css">
	body {
		background-color:#eee;
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
	}

	h1 {
		font-size:24px;
		font-weight:normal;
		color:#666;
	}

	div {
		padding:10px;
		background-color:green;
		margin-bottom:5px;
		color:#fff;
		border-radius:2px;
	}

	.error {
		background-color:red;
	}

	.realm {
		margin-top:20px;
	}
</style>

<h1>Asking if connections are Online or Offline.</h1>

<?php

require 'application/config/database.php';

function connect($hostname, $username, $password, $port, $database = null)
{
    $connection = new mysqli($hostname, $username, $password, $database, $port);

    if ($connection->connect_errno) {
        die("<div class='error'>mysql connection to CMS database could not be established: " . $connection->error . "</div>");
    }

    return $connection;
}

function selectDb($connection, $database)
{
    if (!$connection->selectDb($database)) {
        die("<div class='error'>mysql connection to CMS database could not be established: " . $connection->error . "</div>");
    }

    return true;
}

$cms_database_connection = connect($db['cms']['hostname'], $db['cms']['username'], $db['cms']['password'], $db['cms']['port'] ?? null);
selectDb($cms_database_connection, $db['cms']['database']);

echo "<div>CMS connection successful</div>";

$auth_database_connection = connect($db['account']['hostname'], $db['account']['username'], $db['account']['password'], $db['account']['port'] ?? null);
selectDb($auth_database_connection, $db['account']['database']);

echo "<div>Realmd/logon/auth connection successful</div>";

if ($cms_database_connection) {
    selectDb($cms_database_connection, $db['cms']['database']);
    $realms = $cms_database_connection->query("SELECT * FROM realms") or die("<div class='error'>Realms table: " . $cms_database_connection->error . "</div>");
    $row    = $realms->fetch_assoc();

    if ($realms->num_rows > 0) {
        do {
            $char = [
                'hostname' => $row['override_hostname_char'] ?? $row['hostname'],
                'username' => $row['override_username_char'] ?? $row['username'],
                'password' => $row['override_password_char'] ?? $row['password'],
                'port'     => $row['override_port_char'] ?? $row['port'] ?? null,
            ];

            $world = [
                'hostname' => $row['override_hostname_world'] ?? $row['hostname'],
                'username' => $row['override_username_world'] ?? $row['username'],
                'password' => $row['override_password_world'] ?? $row['password'],
                'port'     => $row['override_port_world'] ?? $row['port'] ?? null,
            ];

            $characters_connection[$row['id']] = connect($char['hostname'], $char['username'], $char['password'], $char['port']);
            $world_connection[$row['id']]      = connect($world['hostname'], $world['username'], $world['password'], $world['port']);

            echo "<div class='realm'>Realm #" . $row['id'] . " (" . $row['realmName'] . ") connections (world & characters) successful</div>";

            selectDb($characters_connection[$row['id']], $row['char_database']);
            selectDb($world_connection[$row['id']], $row['char_database']);

            try {
                $connect = fsockopen($row['hostname'], $row['realm_port'], $errno, $errstr, 1.5);

                echo $connect ? "<div>" . $row['realmName'] . " is online</div>" : "<div class='error'>" . $row['realmName'] . " is offline</div>";

            } catch (Exception $error) {
                echo "<div class='error'>" . $error->getMessage() . "</div>";
            }
        } while ($row = $realms->fetch_assoc());
    } else {
        die('"realms" table is empty');
    }
} else {
    die('CMS connection not available');
}
<style type="text/css">
	body {
		background-color:silver;
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
        color:#d9534f;
	}

	h1 {
		font-size:24px;
		font-weight:normal;
        color: #363b3e;
        text-transform:uppercase;
        font-weight:bolder;
	}

	div {
        padding:10px;
        background-color:#5cb85c;
        margin-bottom:5px;
        color:#292b2c;
        border-radius:2px;
        font-weight:600;
	}

	.error {
		background-color:#d9534f;
	}

	.realm {
		margin-top:20px;
	}
</style>

<h1>Connection Status</h1>

<?php

require 'application/config/database.php';

function showConnectionError($connection) 
{
    die("<div class='error'>[DB] mysql connection to CMS database could not be established: " . $connection->connect_error . "</div>");
}

function connect($hostname, $username, $password, $port, $database = null)
{
    $connection = new mysqli($hostname, $username, $password, $database, $port);
        
    if ($connection->connect_errno) {
        showConnectionError($connection);
    }

    return $connection;
}

function select_db($connection, $database)
{    
    if (!$connection->select_db($database)) {
        showConnectionError($connection);
    }

    return true;
}

$cms_database_connection = connect($db['cms']['hostname'], $db['cms']['username'], $db['cms']['password'], $db['cms']['port'] ?? null);
select_db($cms_database_connection, $db['cms']['database']);

echo "<div>[DB] CMS connection successful</div>";

$auth_database_connection = connect($db['account']['hostname'], $db['account']['username'], $db['account']['password'], $db['account']['port'] ?? null);
select_db($auth_database_connection, $db['account']['database']);

echo "<div>[DB] Realmd/logon/auth connection successful</div>";

if ($cms_database_connection) {
    select_db($cms_database_connection, $db['cms']['database']);
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

            echo "<div class='realm'>[DB] Realm #" . $row['id'] . " (" . $row['realmName'] . ") connections (world & characters) successful</div>";

            select_db($characters_connection[$row['id']], $row['char_database']);
            select_db($world_connection[$row['id']], $row['char_database']);

            try {
                $connect = fsockopen($row['hostname'], $row['realm_port'], $errno, $errstr, 1.5);

                echo $connect ? "<div>[SERVER] " . $row['realmName'] . " is online</div>" : "<div class='error'>[SERVER] " . $row['realmName'] . " is offline</div>";

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

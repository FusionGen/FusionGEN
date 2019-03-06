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

<h1>Testing your server connections...</h1>

<?php

require('application/config/database.php');

$c1 = mysql_connect($db['cms']['hostname'].((array_key_exists("port", $db['cms'])) ? ":".$db['cms']['port'] : ""), $db['cms']['username'], $db['cms']['password']) or die("<div class='error'>MySQL connection to CMS database  could not be established: ".mysql_error()."</div>");
mysql_select_db($db['cms']['database'], $c1) or die("<div class='error'>MySQL connection to CMS database could not be established: ".mysql_error()."</div>");

echo "<div>CMS connection successful</div>";

$c2 = mysql_connect($db['account']['hostname'].((array_key_exists("port", $db['account'])) ? ":".$db['account']['port'] : ""), $db['account']['username'], $db['account']['password']) or die("<div class='error'>MySQL connection to Realmd/logon/auth database could not be established: ".mysql_error()."</div>");
mysql_select_db($db['account']['database'], $c2) or die("<div class='error'>MySQL connection to Realmd/logon/auth database could not be established: ".mysql_error()."</div>");

echo "<div>Realmd/logon/auth connection successful</div>";

if($c1)
{
	mysql_select_db($db['cms']['database'], $c1) or die("<div class='error'>MySQL connection could not be established: ".mysql_error()."</div>");
	$realms = mysql_query("SELECT * FROM realms", $c1) or die("<div class='error'>Realms table: ".mysql_error()."</div>");
	$row = mysql_fetch_assoc($realms);

	if(mysql_num_rows($realms))
	{
		do
		{
			$char['hostname'] = (array_key_exists("override_hostname_char", $row) && !empty($row['override_hostname_char'])) ? $row['override_hostname_char'] : $row['hostname'];
			$char['username'] = (array_key_exists("override_username_char", $row) && !empty($row['override_username_char'])) ? $row['override_username_char'] : $row['username'];
			$char['password'] = (array_key_exists("override_password_char", $row) && !empty($row['override_password_char'])) ? $row['override_password_char'] : $row['password'];
			$char['port'] = (array_key_exists("override_port_char", $row) && !empty($row['override_port_char'])) ? ":".$row['override_port_char'] : "" ;

			$world['hostname'] = (array_key_exists("override_hostname_world", $row) && !empty($row['override_hostname_world'])) ? $row['override_hostname_world'] : $row['hostname'];
			$world['username'] = (array_key_exists("override_username_world", $row) && !empty($row['override_username_world'])) ? $row['override_username_world'] : $row['username'];
			$world['password'] = (array_key_exists("override_password_world", $row) && !empty($row['override_password_world'])) ? $row['override_password_world'] : $row['password'];
			$world['port'] = (array_key_exists("override_port_world", $row) && !empty($row['override_port_world'])) ? ":".$row['override_port_world'] : "" ;

			$r_char[$row['id']] = mysql_connect($char['hostname'].$char['port'], $char['username'], $char['password']) or die("<div class='error'>".$row['realmName']." error:".mysql_error()."</div>");
			$r_world[$row['id']] = mysql_connect($world['hostname'].$world['port'], $world['username'], $world['password']) or die("<div class='error'>".$row['realmName']." error:".mysql_error()."</div>");

			echo "<div class='realm'>Realm #".$row['id']." (".$row['realmName'].") connections (world & characters) successful</div>";

			mysql_select_db($row['char_database'], $r_char[$row['id']]) or die("<div class='error'>".$row['realmName']." database error: ".mysql_error()."</div>");
			mysql_select_db($row['world_database'], $r_char[$row['id']]) or die("<div class='error'>".$row['realmName']." database error: ".mysql_error()."</div>");

			try {
				$connect = fsockopen($row['hostname'], $row['realm_port'], $errno, $errstr, 1.5);

				if($connect)
				{
					echo "<div>".$row['realmName'] . " is online</div>";
				}
				else
				{
					echo "<div class='error'>".$row['realmName'] . " is offline</div>";
				}
			}
			catch(Exception $error)
			{
				echo "<div class='error'>".$error->getMessage()."</div>";
			}
		}
		while($row = mysql_fetch_assoc($realms));
	}
	else
	{
		die('"realms" table is empty');
	}
}
else
{
	die('CMS connection not available');
}
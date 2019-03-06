<?php

$config['use_forum_bridge'] = false;

/**
 * Default support:
 * phpbb, ipb, smf, mybb
 */
$config['forum_bridge'] = "phpbb, ipb, smf or mybb";
$config['forum_table_prefix'] = "phpbb_";

$config['bridge']['hostname'] = "127.0.0.1";
$config['bridge']['username'] = "root";
$config['bridge']['password'] = "";
$config['bridge']['database'] = "phpbb";
$config['bridge']['dbdriver'] = "mysqli";
$config['bridge']['dbprefix'] = "";
$config['bridge']['pconnect'] = TRUE;
$config['bridge']['db_debug'] = TRUE;
$config['bridge']['cache_on'] = FALSE;
$config['bridge']['cachedir'] = "";
$config['bridge']['char_set'] = "utf8";
$config['bridge']['dbcollat'] = "utf8_general_ci";
$config['bridge']['swap_pre'] = "";
$config['bridge']['autoinit'] = TRUE;
$config['bridge']['stricton'] = FALSE;
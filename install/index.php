<?php

$php_version_success = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$json_success = false;
$gmp_success = false;
$rewrite_success = false;

$php_version_required = "7.1.33";
$current_php_version = PHP_VERSION;

//check required php version
if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}

//check mySql 
if (function_exists("mysqli_connect")) {
    $mysql_success = true;
}

//check curl 
if (function_exists("curl_version")) {
    $curl_success = true;
}

//check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}

//check json
if (extension_loaded('json')) {
    $json_success = true;
}

//check gmp
if (extension_loaded('gmp')) {
    $gmp_success = true;
}

//check soap
if (extension_loaded('soap')) {
    $soap_success = true;
}

//check mbstring
if (extension_loaded('mbstring')) {
    $mbstring_success = true;
}

//check openssl
if (extension_loaded('openssl')) {
    $openssl_success = true;
}

// TODO, check apache modules for PHP FPM & CGI, apache_get_modules doesn't exist there
if(function_exists('apache_get_modules') && in_array('mod_rewrite',apache_get_modules()) ) {
    $rewrite_success = true;
} else {
    $rewrite_success = false;
}

//check if all requirement is success
if ($php_version_success && $mysql_success && $curl_success && $gd_success && $json_success && $gmp_success && $soap_success && $mbstring_success && $openssl_success) {
    $all_requirement_success = true;
} else {
    $all_requirement_success = false;
}

$writeable_directories = array(
    'cache' => '/application/cache/',
    'config' => '/application/config/config.php',
    'modules' => '/application/modules/'
);

foreach ($writeable_directories as $value) {
    if (!is_writeable(".." . $value)) {
        $all_requirement_success = false;
    }
}

$dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $dashboard_url = 'https://' . $dashboard_url;
} else {
    $dashboard_url = 'http://' . $dashboard_url;
}

include "view/index.php";
?>
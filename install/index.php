<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if (file_exists(".lock"))
{
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /index.php");
	exit();
}

$php_version_success = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$gmp_success = false;
$rewrite_success = false;
$soap_success = false;
$openssl_success = false;
$zip_success = false;
$xml_success = false;

$php_version_min = "8.1.0";
$php_version_max = "8.5.1";
$current_php_version = phpversion();

if ($current_php_version <= $php_version_max && $current_php_version >= $php_version_min) {
    $php_version_success = true;
}

// check mysql
if (function_exists("mysqli_connect")) {
    $mysql_success = true;
}

// check curl
if (function_exists("curl_version")) {
    $curl_success = true;
}

// check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}

// check gmp
if (extension_loaded('gmp')) {
    $gmp_success = true;
}

// check soap
if (extension_loaded('soap')) {
    $soap_success = true;
}

// check mbstring
if (extension_loaded('mbstring')) {
    $mbstring_success = true;
}

// check openssl
if (extension_loaded('openssl')) {
    $openssl_success = true;
}

// check zip
if (extension_loaded('zip')) {
    $zip_success = true;
}

// check xml
if (extension_loaded('xml')) {
    $xml_success = true;
}

// check if all requirements are meet
if ($php_version_success && $mysql_success && $curl_success && $gd_success && $gmp_success && $soap_success && $mbstring_success && $openssl_success && $zip_success && $xml_success) {
    $all_requirement_success = true;
} else {
    $all_requirement_success = false;
}

$writeable_directories = [
    'cache' => '/application/cache/',
    'config' => '/application/config/config.php'
];

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

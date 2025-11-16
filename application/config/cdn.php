<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package FusionGen
 * @version 6.0
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Err0r
 * @link    http://fusiongen.net
 */

/*
|--------------------------------------------------------------------------
| CDN system
|--------------------------------------------------------------------------
|
| If activated, most static files (js/css/images) are loaded from GitHub via the FusionGEN CDN system
|
| This should speed up the loading time of the website
|
*/

$config['cdn'] = false;
$config['cdn_link'] = "https://cdn.jsdelivr.net/gh/fusiongen/fusiongen@main/";

<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
| If activated, static files (js/css/images) are loaded from github via the fusiongen CDN system
|
| This should speed up the loading time of the website
|
| Only default theme.
*/

$config['cdn'] = false;
$config['cdn_link'] = "https://cdn.jsdelivr.net/gh/fusiongen/fusiongen@main/";

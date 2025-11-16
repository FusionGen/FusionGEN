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
  | Default Language
  |--------------------------------------------------------------------------
  |
  | Also acts as fallback language
  |
 */
$config['language'] = "english";

/*
  |--------------------------------------------------------------------------
  | Detect Browser Language
  |--------------------------------------------------------------------------
  |
  | If enabled detecting browser language and set user language to detected language
  |
 */
$config['detect_language'] = false;

/*
|--------------------------------------------------------------------------
| Supported Languages
|--------------------------------------------------------------------------
*/
$config['supported_languages'] = [
    'en' => ['name' => 'english'],
    'es' => ['name' => 'spanish'],
    'fr' => ['name' => 'french'],
    'ro' => ['name' => 'romanian']
    //'de' => ['name' => 'deutsch']
];

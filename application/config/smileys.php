<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| SMILEYS
| -------------------------------------------------------------------
| This file contains an array of smileys for use with the emoticon helper.
| Individual images can be used to replace multiple simileys.  For example:
| :-) and :) use the same image replacement.
|
| Please see user guide for more info:
| http://codeigniter.com/user_guide/helpers/smiley_helper.html
|
*/

$smileys = array(

//	smiley			image name						width	height	alt

	':-)'			=>	array('emoticon_grin.png',			'16',	'16',	'grin'),
	':)'			=>  array('emoticon_smile.png',			'16',	'16',	'smile'),
	'xD'			=>  array('emoticon_evilgrin.png',		'16',	'16',	'evilgrin'),
	'XD'			=>  array('emoticon_evilgrin.png',		'16',	'16',	'evilgrin'),
	':D'			=>  array('emoticon_happy.png',			'16',	'16',	'happy'),
	':O'			=>  array('emoticon_surprised.png',		'16',	'16',	'surprised'),
	':P'			=>  array('emoticon_tongue.png',		'16',	'16',	'tongue'),
	':p'			=>  array('emoticon_tongue.png',		'16',	'16',	'tongue'),
	':('			=>  array('emoticon_unhappy.png',		'16',	'16',	'unhappy'),
	':3'			=>  array('emoticon_waii.png',			'16',	'16',	'waii'),
	';)'			=>  array('emoticon_wink.png',			'16',	'16',	'wink')//no comma on the last one.
		);

/* End of file smileys.php */
/* Location: ./application/config/smileys.php */
<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
| Ex.: <smilie>.png, <image name>, <width>, <height>, <alt>
 */

$smileys = [
    ':-)' => ['emoticon_grin.png', '16', '16', 'grin'],
    ':)'  => ['emoticon_smile.png', '16', '16', 'smile'],
    'xD'  => ['emoticon_evilgrin.png', '16', '16', 'evilgrin'],
    'XD'  => ['emoticon_evilgrin.png', '16', '16', 'evilgrin'],
    ':D'  => ['emoticon_happy.png', '16', '16', 'happy'],
    ':O'  => ['emoticon_surprised.png', '16', '16', 'surprised'],
    ':P'  => ['emoticon_tongue.png', '16', '16', 'tongue'],
    ':p'  => ['emoticon_tongue.png', '16', '16', 'tongue'],
    ':('  => ['emoticon_unhappy.png', '16', '16', 'unhappy'],
    ':3'  => ['emoticon_waii.png', '16', '16', 'waii'],
    ';)'  => ['emoticon_wink.png', '16', '16', 'wink'],
];

/* End of file smileys.php */
/* Location: ./application/config/smileys.php */

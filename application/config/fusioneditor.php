<?php

/**
 * @package FusionCMS
 * @version 6.0
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @link http://fusion-hub.com
 */

$config['fusioneditor'] = array(

    'bold'      => [
        'enabled' => true,
        'text'    => "Bold",
        'icon'    => "text_bold",
        'compile' => [
            'regex_search'  => "/<b>(.*?)?<\/b>/i",
            'regex_replace' => "[b]$1[/b]",
        ],
        'parse'   => [
            'regex_search'  => "/\[b\](.*?)?\[\/b\]/i",
            'regex_replace' => "<b>$1</b>",
        ],
    ],

    'italic'    => [
        'enabled' => true,
        'text'    => "Italic",
        'icon'    => "text_italic",
        'compile' => [
            'regex_search'  => "/<i>(.*?)?<\/i>/i",
            'regex_replace' => "[i]$1[/i]",
        ],
        'parse'   => [
            'regex_search'  => "/\[i\](.*?)?\[\/i\]/i",
            'regex_replace' => "<i>$1</i>",
        ],
    ],

    'underline' => [
        'enabled' => true,
        'text'    => "Underline",
        'icon'    => "text_underline",
        'compile' => [
            'regex_search'  => "/<u>(.*?)?<\/u>/i",
            'regex_replace' => "[u]$1[/u]",
        ],
        'parse'   => [
            'regex_search'  => "/\[u\](.*?)?\[\/u\]/i",
            'regex_replace' => "<u>$1</u>",
        ],
    ],

    'size'      => [
        'enabled' => true,
        'text'    => "Change text size",
        'icon'    => "font",
        'compile' => [
            'regex_search'  => "/<span style=[\"']font-size: ?([0-9]*)px;?[\"']>(.*?)?<\/span>/i",
            'regex_replace' => "[size=$1]$2[/size]",
        ],
        'parse'   => [
            'regex_search'  => "/\[size=([0-9]*)\](.*?)?\[\/size\]/i",
            'regex_replace' => "<span style='font-size:$1px'>$2</span>",
        ],
    ],

    'image'     => [
        'enabled' => true,
        'text'    => "Insert image",
        'icon'    => "picture",
        'compile' => [
            'regex_search'  => "/<img src=[\"'](http:\/\/[A-Za-z0-9-_.+~: \/]*)[\"'] ?\/?>/",
            'regex_replace' => "[img]$1[/img]",
        ],
        'parse'   => [
            'regex_search'  => "/\[img\](.*)\[\/img\]/",
            'regex_replace' => "<img src='$1' />",
        ],
    ],

    'color'     => [
        'enabled' => true,
        'text'    => "Change color",
        'icon'    => "color_wheel",
        'compile' => [
            'regex_search'  => "/<span style=[\"']color: ?#(([a-fA-F0-9]){3,6});?[\"']>(.*?)?<\/span>/i",
            'regex_replace' => "[color=#$1]$3[/color]",
        ],
        'parse'   => [
            'regex_search'  => "/\[color=#(([a-fA-F0-9]){3,6})\](.*?)?\[\/color\]/i",
            'regex_replace' => "<span style='color:#$1'>$3</span>",
        ],
    ],

    'link'      => [
        'enabled' => true,
        'text'    => "Insert link",
        'icon'    => "link",
        'compile' => [
            'regex_search'  => "/<a href=[\"'](http:\/\/[A-Za-z0-9-_.+~: \/]*)[\"']>(.*?)?<\/a>/i",
            'regex_replace' => "[link=$1]$2[/link]",
        ],
        'parse'   => [
            'regex_search'  => "/\[link=(http:\/\/[A-Za-z0-9-_.+~: \/]*)\](.*?)?\[\/link\]/i",
            'regex_replace' => "<a href='$1' target='_blank'>$2</a>",
        ],
    ],

    'left'      => [
        'enabled' => true,
        'text'    => "Align left",
        'icon'    => "text_align_left",
        'compile' => [
            'regex_search'  => "/<div style=[\"']text-align: ?left;?[\"']>(.*?)?<\/div>/i",
            'regex_replace' => "[left]$1[/left]",
        ],
        'parse'   => [
            'regex_search'  => "/\[left\](.*?)?\[\/left\]/i",
            'regex_replace' => "<div style='text-align:left;'>$1</div>",
        ],
    ],

    'center'    => [
        'enabled' => true,
        'text'    => "Align center",
        'icon'    => "text_align_center",
        'compile' => [
            'regex_search'  => "/<div style=[\"']text-align: ?center;?[\"']>(.*?)?<\/div>/i",
            'regex_replace' => "[center]$1[/center]",
        ],
        'parse'   => [
            'regex_search'  => "/\[center\](.*?)?\[\/center\]/i",
            'regex_replace' => "<div style='text-align:center;'>$1</div>",
        ],
    ],

    'right'     => [
        'enabled' => true,
        'text'    => "Align right",
        'icon'    => "text_align_right",
        'compile' => [
            'regex_search'  => "/<div style=[\"']text-align: ?right;?[\"']>(.*?)?<\/div>/i",
            'regex_replace' => "[right]$1[/right]",
        ],
        'parse'   => [
            'regex_search'  => "/\[right\](.*?)?\[\/right\]/i",
            'regex_replace' => "<div style='text-align:right;'>$1</div>",
        ],
    ],

    'html'      => [
        'enabled' => true,
        'text'    => "Edit HTML source",
        'icon'    => "tag",
        'compile' => [
            'regex_search'  => "",
            'regex_replace' => "",
        ],
        'parse'   => [
            'regex_search'  => "",
            'regex_replace' => "",
        ],
    ],

    'tidy'      => [
        'enabled' => true,
        'text'    => "Reset all styles",
        'icon'    => "cross",
        'compile' => [
            'regex_search'  => "",
            'regex_replace' => "",
        ],
        'parse'   => [
            'regex_search'  => "",
            'regex_replace' => "",
        ],
    ],
);

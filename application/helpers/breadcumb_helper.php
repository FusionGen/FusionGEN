<?php

/**
 * Create a breadcumb for headlines
 * Item A → Item B → Item C
 * @param array $items
 * @return string
 */
function breadcumb($items)
{
    $CI = &get_instance();

    $data = [
        "links" => $items,
        "url"   => pageURL,
    ];

    return $CI->smarty->view($CI->template->view_path . "breadcumb.tpl", $data, true);
}

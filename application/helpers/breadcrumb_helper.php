<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create a breadcrumb for headlines
 * Item A → Item B → Item C
 *
 * @param  Array $items
 * @return String
 */
function breadcrumb($items)
{
    $CI = &get_instance();

    $data = array(
        "links" => $items,
        "url" => pageURL
    );

    return $CI->smarty->view($CI->template->view_path . "breadcrumb.tpl", $data, true);
}

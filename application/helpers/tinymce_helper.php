<?php

/**
 * Output TinyMCE script
 */
function TinyMCE()
{
	$CI = &get_instance();
	
	$data = array("url" => pageURL);

	return $CI->smarty->view($CI->template->view_path."tinymce.tpl", $data, true);
}
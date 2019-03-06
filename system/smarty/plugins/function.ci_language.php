<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {ci_language} function plugin
 *
 * Type:     function<br>
 * Name:     ci_language<br>
 * Purpose:  bridge to code igniter language files
 * @author Neighbor Webmastert <kepler ar neighborwebmaster dot com>
 * @param array Format:
 * <pre>
 * array('lang' => option language identifier - defaults to 'en')
 * </pre>
 * @param Smarty
 */
function smarty_function_ci_language($params, &$smarty)
{
        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $_debug_start_time = smarty_core_get_microtime($_params, $smarty);
        }

        $_lang = isset($params['lang']) ? $params['lang'] : 'en';
        $_file = isset($params['file']) ? $params['file'] : '';
        $_line = isset($params['line']) ? $params['line'] : '';
        $_template = isset($params['template']) ? $params['template'] : '';
        $_assign = isset($params['assign']) ? $params['assign'] : '';

        if (substr($_lang, 0, 1) == '$')
        {
            $_lang = $smarty->get_template_vars( substr($_lang, 1) );
        }
        if (substr($_file, 0, 1) == '$')
        {
            $_file = $smarty->get_template_vars( substr($_file, 1) );
        }
        if (substr($_line, 0, 1) == '$')
        {
            $_line = $smarty->get_template_vars( substr($_line, 1) );
        }
        /*
        if (substr($_template, 0, 1) == '$')
        {
            $_template = $smarty->get_template_vars( substr($_template, 1) );
        }
         */
		$CI = &get_instance();
		if ($_file != '') $CI->lang->load($_file, $_lang);

        if ($_line != '')
        {
// echo "KEY ->".$_line."<-";
// echo "TEMPLATE ->".$_template."<-";
            if ($_template != '')
            {
                $line = str_replace('$', $_line, $_template);
            }
            else
            {
                $line = $_line;
            }
// echo "LINE ->".$line."<-";

	        $val = $CI->lang->line($line);
            if ( $val == '' )
            {
	            $val = $line;
            }

            if ($_assign != '')
            {
	            $smarty->assign( $_assign, $val );
            }
            else
            {
	            echo $val;
            }
        }
        /*
        else
        {
		    $arr = $CI->lang->fetch($_lang);
            if (isset($arr) && is_array($arr))
            {
		        foreach( $arr as $name => $value )
		        {
			        $smarty->assign( $name, $value );
		        }
            }
        }
         */

        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $smarty->_smarty_debug_info[] = array('type'      => 'config',
                                                'filename'  => $_file.' ['.$_section.'] '.$_scope,
                                                'depth'     => $smarty->_inclusion_depth,
                                                'exec_time' => smarty_core_get_microtime($_params, $smarty) - $_debug_start_time);
        }

}

/* vim: set expandtab: */

?>

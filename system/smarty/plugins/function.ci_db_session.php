<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {ci_db_session} function plugin
 *
 * Type:     function<br>
 * Name:     ci_db_session<br>
 * Purpose:  bridge to code igniter db_session properties
 * @author Neighbor Webmastert <kepler ar neighborwebmaster dot com>
 * @param array Format:
 * <pre>
 * array(
 *   'name' => required name of the db_session properties
 *   'type' => optional type 'user' or 'flash' - defaults to 'user'
 *   'assign' => optional smarty variable name to assign to - defaults to name
 * )
 * </pre>
 * @param Smarty
 */
function smarty_function_ci_db_session($params, &$smarty)
{
        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $_debug_start_time = smarty_core_get_microtime($_params, $smarty);
        }

        $_name = isset($params['name']) ? $params['name'] : '';
        $_type = isset($params['type']) ? $params['type'] : 'user';
        $_assign = isset($params['assign']) ? $params['assign'] : $_name;

        if ($_name != '')
        {
		    // get a Code Igniter instance
		    $CI = &get_instance();
		    $value = '';
            if ($_type == 'user')
            {
		        $value = $CI->db_session->userdata($_name);
            }
            else // flash
            {
		        $value = $CI->db_session->flashdata($_name);
            }
		    $smarty->assign( $_assign, $value );
		}

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

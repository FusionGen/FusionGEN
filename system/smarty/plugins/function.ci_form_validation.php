<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {ci_form_validation} function plugin
 *
 * Type:     function<br>
 * Name:     ci_form_validation<br>
 * Purpose:  bridge to code igniter form validation properties
 * @author Neighbor Webmaster <kepler ar neighborwebmaster dot com>
 * @param array Format:
 * <pre>
 * array(
 *   'field' => required field validation property
 *   'error' => optional boolean indicating whether this is an error message
 *   'assign' => optional variable to assign the error message to - defaults to output
 *   'type' => optional class name of your own form_validation
 * )
 * </pre>
 * @param Smarty
 */
function smarty_function_ci_form_validation($params, &$smarty)
{
        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $_debug_start_time = smarty_core_get_microtime($_params, $smarty);
        }

        $_field = isset($params['field']) ? $params['field'] : '';
        $_type = isset($params['type']) ? $params['type'] : '';
        $_error = isset($params['error']) ? ((strcasecmp($params['error'], "true") == 0) ? true : false ) : false;
        $_assign = isset($params['assign']) ? $params['assign'] : null;

        if ($_field != '')
        {
            if (substr($_field, 0, 1) == '$')
            {
                $_field = $smarty->get_template_vars( substr($_field, 1) );
            }
            // get a Code Igniter instance
            $CI = &get_instance();
            $_validation = $CI->form_validation;

            // did you want to use your own form_validation class instead?
            if ($_type != '')
            {
                $_validation = $CI->$_type;
            }

            if ( $_error )
            {
                $value = $_validation->error($_field);
            }
            else
            {
                $value = $_validation->set_value($_field);
            }

            if ( isset( $_assign ) )
            {
                $smarty->assign( $_assign, $value );
            }
            else
            {
                echo $value;
            }
        }

        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $smarty->_smarty_debug_info[] = array('type'      => 'validation',
                                                'filename'  => $_file.' ['.$_section.'] '.$_scope,
                                                'depth'     => $smarty->_inclusion_depth,
                                                'exec_time' => smarty_core_get_microtime($_params, $smarty) - $_debug_start_time);
        }

}

/* vim: set expandtab: */

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package FusionGen
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    http://fusiongen.net
 */

use Smarty\Smarty;

class My_Smarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(APPPATH);
        $this->setCompileDir(APPPATH . "cache/templates");
        $this->setCompileCheck(ENVIRONMENT !== 'production');
        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);

        $this->registerModifiers();

        log_message('debug', "Smarty Class Initialized");
    }

    /**
     *  Parse a template using the Smarty engine
     *
     * This is a convenience method that combines assign() and
     * display() into one step.
     *
     * Values to assign are passed in an associative array of
     * name => value pairs.
     *
     * If the output is to be returned as a string to the caller
     * instead of being output, pass true as the third parameter.
     *
     * @access public
     * @param  string
     * @param  array
     * @param  bool
     * @return string
     */
    public function view($template, $data = [], $return = false)
    {
        try {
            $this->assign($data);

            // Render the template
            $output = $this->fetch($template);

            if ($return)
            {
                return $output;
            }

            get_instance()->output->set_output($output);
        } catch (\Smarty\Exception $e) {

            log_message('error', 'Smarty error: ' . $e->getMessage());

            if (ENVIRONMENT !== 'production') {
                $message = "An error has occurred while trying to load the requested view.\n\n" . "Template path: {$template}\n\n" . (string) $e;
                show_error('<pre>' . html_escape($message) . '</pre>', 500, 'Smarty Template Error');
            } else {
                show_error('An error has occurred while trying to load the requested view.', 500, 'Template Error');
            }

        }
    }

    private function registerModifiers()
    {
        // Assign modifiers
        $modifiers = ['lang' ,'langColumn', 'hasPermission', 'form_open', 'form_close', 'set_value', 'htmlspecialchars', 'preg_replace', 'str_replace', 'strtolower', 'reset', 'key', 'date', 'ucfirst', 'addslashes', 'array_keys', 'array_key_exists', 'end', 'trim', 'floor', 'str_contains', 'strtoupper', 'json_decode', 'character_limiter', 'ctype_digit'];

        foreach ($modifiers as $mname) {
            if (is_callable($mname))
            {
                $this->registerPlugin('modifier', $mname, $mname);
            }
        }
    }
}
// END Smarty Class

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

        $this->setCompileDir(APPPATH . "cache/templates");
        $this->setTemplateDir(APPPATH);
        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);

        // Assign modifiers
        $modifiers = ['lang' ,'langColumn', 'hasPermission', 'form_open', 'form_close', 'set_value', 'TinyMCE', 'htmlspecialchars', 'preg_replace', 'str_replace', 'strtolower', 'reset', 'key', 'strtotime', 'date', 'ucfirst', 'addslashes', 'time', 'array_keys', 'array_key_exists', 'end', 'trim', 'floor', 'str_contains', 'strtoupper', 'json_decode', 'base64_encode', 'character_limiter', 'ctype_digit'];

        foreach ($modifiers as $mname) {
            $this->registerPlugin('modifier', $mname, $mname);
        }

        // Assign CodeIgniter object by reference to CI
        if (method_exists($this, 'assignByRef')) {
            $CI = &get_instance();
            $this->assignByRef("ci", $CI);
        }

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
            if ($data == '') {
                $data = [];
            }

            foreach ($data as $key => $val) {
                $this->assign($key, $val);
            }

            if ($return == false) {
                $CI = &get_instance();
                if (method_exists($CI->output, 'set_output')) {
                    $CI->output->set_output($this->fetch($template));
                } else {
                    $CI->output->final_output = $this->fetch($template);
                }
                return;
            } else {
                return $this->fetch($template);
            }
        } catch (\Smarty\Exception $e) {

            log_message('error', 'Smarty error: ' . $e->getMessage());

            if (ENVIRONMENT !== 'production') {
                $message = "An error has occured while trying to load the requested view.\n\n" . "Template path: {$template}\n\n" . (string) $e;
                show_error('<pre>' . htmlspecialchars($message) . '</pre>', 500, 'Smarty Template Error');
            } else {
                show_error('An error has occurred while trying to load the requested view.', 500, 'Template Error');
            }

        }
    }
}
// END Smarty Class

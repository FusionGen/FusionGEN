<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionGen
 * @author  Jesper Lindstr�m
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    http://fusiongen.net
 */

class Plugin
{
    protected $CI;
    public $module_name;
    private $vars = array();

    /**
     * Get the instance of CI and load the plugin name
     */
    public function __construct($config = null)
    {
        $this->CI = &get_instance();
        $this->module_name = $this->CI->router->fetch_module();
        $this->name = get_class($this);
        $this->config = $config;
    }

    /**
     * Sets a variable to the given value
     *
     * @param String
     * @param mixed
     */
    public function __set($name, $val)
    {
        $this->vars[$name] = $val;
    }

    /**
     * Gets any variables that exist under the passed name.
     *
     * @param  String
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->vars)) {
            return $this->vars[$name];
        } else {
            return null;
        }
    }
}

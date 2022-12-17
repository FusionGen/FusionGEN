<?php

defined('BASEPATH') or exit('No direct script access allowed');

defined('EXT') or define('EXT', '.php');

global $CFG;

/* get module locations from config settings or use the default module location and offset */
is_array(_Modules::$locations = $CFG->item('modules_locations')) or _Modules::$locations = array(
    APPPATH . 'modules/' => '../modules/',
);

/* PHP5 spl_autoload */
spl_autoload_register('_Modules::autoload');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 *
 * @link http://codeigniter.com
 *
 * Description:
 * This library provides functions to load and instantiate controllers
 * and module controllers allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Modules.php
 *
 * @copyright Copyright (c) 2015 Wiredesignz
 * @version   5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class _Modules
{
    public static $routes;
    public static $registry;
    public static $locations;

    /**
     * [Run a module controller method, output from module is buffered and returned.]
     *
     * @method run
     *
     * @param [type] $module [description]
     *
     * @return [type]         [description]
     */
    public static function run($module)
    {
        $method = 'index';

        if (($pos = strrpos($module, '/')) !== false) {
            $method = substr($module, $pos + 1);
            $module = substr($module, 0, $pos);
        }

        if ($class = self::load($module)) {
            if (method_exists($class, $method)) {
                ob_start();
                $args = func_get_args();
                $output = call_user_func_array(array($class, $method), array_slice($args, 1));
                $buffer = ob_get_clean();
                return $output ?? $buffer;
            }
        }

        log_message('error', "Module controller failed to run: {$module}/{$method}");
    }

    /**
     * [Load a module controller]
     *
     * @method load
     *
     * @param [type] $module [description]
     *
     * @return [type]         [description]
     */
    public static function load($module)
    {
        // Backward function
        // The function each() has been DEPRECATED as of PHP 7.2.0. Relying on this function is highly discouraged
        // Before PHP 7.1.0, list() only worked on numerical arrays and assumes the numerical indices start at 0.
        if (version_compare(phpversion(), '7.1', '<')) {
            // php version isn't high enough
            is_array($module) ? list($module, $params) = each($module) : $params = null;
        } else {
            if (!is_array($module)) {
                $params = null;
            } else {
                $keys = array_keys($module);

                $params = $module[$keys[0]];

                $module = $keys[0];
            }
        }

        /* get the requested controller class name */
        $alias = strtolower(basename($module));

        /* create or return an existing controller from the registry */
        if (!isset(self::$registry[$alias])) {
            // Backward function
            // Before PHP 7.1.0, list() only worked on numerical arrays and assumes the numerical indices start at 0.
            if (version_compare(phpversion(), '7.1', '<')) {
                // php version isn't high enough
                /* find the controller */
                list($class) = CI::$APP->router->locate(explode('/', $module));
            } else {
                [$class] = CI::$APP->router->locate(explode('/', $module));
            }

            /* controller cannot be located */
            if (empty($class)) {
                return;
            }

            /* set the module directory */
            $path = APPPATH . 'controllers/' . CI::$APP->router->directory;

            /* load the controller class */
            $class .= CI::$APP->config->item('controller_suffix');
            self::load_file(ucfirst($class), $path);

            /* create and register the new controller */
            $controller = ucfirst($class);
            self::$registry[$alias] = new $controller($params);
        }

        return self::$registry[$alias];
    }

    /**
     * [Library base class autoload]
     *
     * @method autoload
     *
     * @param [type]   $class [description]
     *
     * @return [type]          [description]
     */
    public static function autoload($class)
    {
        /* don't autoload CI_ prefixed classes or those using the config subclass_prefix */
        if (strstr($class, 'CI_') || strstr($class, config_item('subclass_prefix'))) {
            return;
        }

        /* autoload Modular Extensions MX core classes */
        if (strstr($class, 'MX_')) {
            if (is_file($location = dirname(__FILE__) . '/' . substr($class, 3) . EXT)) {
                include_once $location;
                return;
            }
            show_error('Failed to load MX core class: ' . $class);
        }

        /* autoload core classes */
        if (is_file($location = APPPATH . 'core/' . ucfirst($class) . EXT)) {
            include_once $location;
            return;
        }

        /* autoload library classes */
        if (is_file($location = APPPATH . 'libraries/' . ucfirst($class) . EXT)) {
            include_once $location;
            return;
        }
    }

    /**
     * [Load a module file]
     *
     * @method load_file
     *
     * @param [type]    $file   [description]
     * @param [type]    $path   [description]
     * @param string    $type   [description]
     * @param boolean   $result [description]
     *
     * @return [type]            [description]
     */
    public static function load_file($file, $path, $type = 'other', $result = true)
    {
        $file = str_replace(EXT, '', $file);
        $location = $path . $file . EXT;

        if ($type === 'other') {
            if (class_exists($file, false)) {
                log_message('debug', "File already loaded: {$location}");
                return $result;
            }
            include_once $location;
        } else {
            /* load config or language array */
            include $location;

            if (! isset($$type) || ! is_array($$type)) {
                show_error("{$location} does not contain a valid {$type} array");
            }

            $result = $$type;
        }
        log_message('debug', "File loaded: {$location}");
        return $result;
    }

    /**
     * [Find a file,
     *  scans for files located within modules directories,
     *  also scans application directories for models,
     *  plugins and views, Generates fatal error if file not found]
     *
     * @method find
     *
     * @param [type] $file   [description]
     * @param [type] $module [description]
     * @param [type] $base   [description]
     *
     * @return [type]         [description]
     */
    public static function find($file, $module, $base)
    {
        $segments = explode('/', $file);

        $file = array_pop($segments);
        $file_ext = pathinfo($file, PATHINFO_EXTENSION) ? $file : $file . EXT;

        $path = ltrim(implode('/', $segments) . '/', '/');
        $module ? $_modules[$module] = $path : $_modules = array();

        if (! empty($segments)) {
            $_modules[array_shift($segments)] = ltrim(implode('/', $segments) . '/', '/');
        }

        foreach (self::$locations as $location => $offset) {
            foreach ($_modules as $module => $subpath) {
                $fullpath = $location . $module . '/' . $base . $subpath;

                if ($base === 'libraries/' || $base === 'models/') {
                    if (is_file($fullpath . ucfirst($file_ext))) {
                        return array($fullpath, ucfirst($file));
                    }
                } elseif /* load non-class files */
                (is_file($fullpath . $file_ext)) {
                    return array($fullpath, $file);
                }
            }
        }

        return array(false, $file);
    }

    /**
     * [Parse module routes]
     *
     * @method parse_routes
     *
     * @param [type]       $module [description]
     * @param [type]       $uri    [description]
     *
     * @return [type]               [description]
     */
    public static function parse_routes($module, $uri)
    {
        /* load the route file */
        if (! isset(self::$routes[$module])) {
            // Backward function
            // Before PHP 7.1.0, list() only worked on numerical arrays and assumes the numerical indices start at 0.
            if (version_compare(phpversion(), '7.1', '<')) {
                // php version isn't high enough
                if (list($path) = self::find('routes', $module, 'config/')) {
                    $path && self::$routes[$module] = self::load_file('routes', $path, 'route');
                }
            } else {
                if ([$path] = self::find('routes', $module, 'config/')) {
                    $path && self::$routes[$module] = self::load_file('routes', $path, 'route');
                }
            }
        }

        if (! isset(self::$routes[$module])) {
            return;
        }

        // Add http verb support for each module routing
        $http_verb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

        /* parse module routes */
        foreach (self::$routes[$module] as $key => $val) {
            // Add http verb support for each module routing
            if (is_array($val)) {
                $val = array_change_key_case($val, CASE_LOWER);

                if (isset($val[$http_verb])) {
                    $val = $val[$http_verb];
                } else {
                    continue;
                }
            }

            $key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);

            if (preg_match('#^' . $key . '$#', $uri)) {
                if (strpos($val, '$') !== false && strpos($key, '(') !== false) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }
                return explode('/', $module . '/' . $val);
            }
        }
    }
}

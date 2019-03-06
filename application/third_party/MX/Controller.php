<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
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
class MX_Controller 
{
	public $autoload = array();
	private $standardModule = "news";

	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		
		log_message('debug', $class." MX_Controller Initialized");

		Modules::$registry[strtolower($class)] = $this;

		// We need the MODULE name, not the controller
		$moduleName = CI::$APP->uri->segment(1);

		// Default module
		if(!$moduleName)
		{
			$moduleName = $this->standardModule;
		}

		// Check if the path exists to the requested module, also make sure to check if the module exists.
		$path = APPPATH.'modules/'.strtolower($moduleName);

		// Does the folder exist?
		if(!is_dir($path))
		{
			CI::$APP->template->show404();
		}

		// Make sure the module has a manifest
		if(!file_exists($path."/manifest.json"))
		{
			show_error("The manifest.json file for <b>".strtolower($moduleName)."</b> does not exist");
		}

		$module = file_get_contents($path."/manifest.json");
		$module = json_decode($module, true);

		// Make sure it was real JSON
		if(!is_array($module))
		{
			show_error("The manifest.json file for <b>".strtolower($moduleName)."</b> is not properly formatted");
		}

		// Is the module enabled?
		if(!isset($module['enabled']) || !$module['enabled'])
		{
			CI::$APP->template->show404();
		}

		// Default to current version
		if(!array_key_exists("min_required_version", $module))
		{
			$module['min_required_version'] = CI::$APP->config->item('FusionCMSVersion');
		}

		// Does the module got the correct version?
		if(!CI::$APP->template->compareVersions($module['min_required_version'], CI::$APP->config->item('FusionCMSVersion')))
		{
			show_error("The module <b>".strtolower($moduleName)."</b> requires FusionCMS v".$module['min_required_version'].", please update at fusion-hub.com");
		}

		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);

		$this->cookieLogIn();
	}
	
	public function __get($class) {
		return CI::$APP->$class;
	}

	public function cookieLogIn()
	{
		if(!CI::$APP->user->isOnline())
		{
			$username = CI::$APP->input->cookie("fcms_username");
			$password = CI::$APP->input->cookie("fcms_password");

			if($username && $password)
			{
				$check = CI::$APP->user->setUserDetails($username, $password);

				if($check == 0)
				{
					redirect('news');
				}
			}
		}
	}
}
<?php

/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class Template
{
	private $CI;
	private $title;
	private $custom_description;
	private $custom_keywords;
	public $theme_path;
	public $page_path;
	public $full_theme_path;
	public $image_path;
	public $theme;
	public $page_url;
	public $theme_data;
	public $style_path;
	public $view_path;
	public $module_name;

	/**
	 * Get the CI instance and create the paths
	 */
	public function __construct()
	{
		$this->CI = &get_instance();

		// Get the theme name
		$this->theme = $this->CI->config->item('theme');

		// Construct the paths
		$this->module_name = $this->CI->router->fetch_module();
		$this->theme_path = "themes/".$this->theme."/";
		$this->view_path = "views/";
		$this->style_path = base_url().APPPATH."themes/".$this->theme."/css/";
		$this->image_path = base_url().APPPATH."themes/".$this->theme."/images/";
		$this->page_url = ($this->CI->config->item('rewrite')) ? base_url() : base_url().'index.php/';
		$this->loadManifest();
		$this->title = "";

		if(!defined("pageURL"))
		{
			define("pageURL", $this->page_url);
		}
	}

	/**
	 * Loads the current theme values
	 */
	private function loadManifest()
	{
		if(!file_exists(APPPATH.$this->theme_path))
		{
			show_error("Invalid theme. The folder <b>".APPPATH.$this->theme_path."</b> doesn't exist!");
		}
		elseif(!file_exists(APPPATH.$this->theme_path."/manifest.json"))
		{
			show_error("Invalid theme. The file <b>manifest.json</b> is missing!");
		}

		// Load the manifest
		$data = file_get_contents(APPPATH.$this->theme_path."manifest.json");

		// Convert to array
		$array = json_decode($data, true);

		// Fix the favicon link
		$array['favicon'] = $this->image_path.$array['favicon'];
		
		if(!isset($array['blank_header'])) {$array['blank_header'] = '';}

		// Save the data
		$this->theme_data = $array;
	}


	/**
	 * Returns if the slider should be shown on the current page.
	 * @return bool
	 */
	private function isSliderShown()
	{
		// Is it enabled?
		if($this->CI->config->item('slider'))
		{
			// Only on news page?, if yes make sure we are on the news page, then show it
			if($this->CI->config->item('slider_home') && $this->CI->router->class == "news")
			{
				return true;
			}

			// If we want to only show it on the home page, then do not show it on the other pages.
			elseif($this->CI->config->item('slider_home') && $this->CI->router->class != "news")
			{
				return false;
			}

			return true;
		}

		return false;
	}
	
	/**
	 * Loads the template
	 * @param String $content The page content
	 * @param String $css Full path to your css file
	 * @param String $js Full path to your js file
	 */
	public function view($content, $css = false, $js = false)
	{
		// Avoid loading the main site in the ACP layout
		if($this->CI->input->get('is_acp'))
		{
			$this->CI->load->library('administrator');
			$this->CI->administrator->view('<script>window.location.reload(true)</script>');
		}

		$output = "";

		if($this->CI->config->item("message_enabled"))
		{
			$output = $this->handleAnnouncement();
		}
		elseif($this->CI->input->is_ajax_request() && isset($_GET['is_json_ajax']) && $_GET['is_json_ajax'] == 1)
		{
			$output = $this->handleAjaxRequest($content, $css, $js);
		}
		else
		{
			$output = $this->handleNormalPage($content, $css, $js);
		}

		// Output and stop rendering
		die($output);
	}

	/**
	 * Handles the normal loading.
	 * @param $content
	 * @param $css
	 * @param $js
	 * @return mixed
	 */
	private function handleNormalPage($content, $css, $js)
	{
		//Load the sideboxes
		$sideboxes = $this->loadSideboxes();
		$header = $this->getHeader($css, $js);
		$modals = $this->getModals();

		$url = $this->CI->router->fetch_class();

		if($this->CI->router->fetch_method() != "index")
		{
			$url .= "/".$this->CI->router->fetch_method();
		}

		// Gather the theme data
		$theme_data = array(
			"currentPage" => $url,
			"url" => $this->page_url,
			"theme_path" => $this->theme_path,
			"full_theme_path" => $this->page_url."application/".$this->theme_path,
			"serverName" => $this->CI->config->item('server_name'),
			"page" => '<div id="content_ajax">'.$content.'</div>',
			"slider" => $this->getSlider(),
			"show_slider" => $this->isSliderShown(),
			"head" => $header,
			"modals" => $modals,
			"CI" => $this->CI,
			"image_path" => $this->image_path,
			"isOnline" => $this->CI->user->isOnline(),
			"header_url" => ($this->CI->config->item('header_url')) ? "style='background-image:url(".$this->CI->config->item('header_url').")'" : "",
			"sideboxes" => $sideboxes
		);

		// Load the main template
		return $output = $this->CI->smarty->view($this->theme_path."template.tpl", $theme_data, true);
	}

	/**
	 * When an ajax request is made to a page it calls this.
	 * @param string $content
	 * @param string $css
	 * @param string $js
	 * @return string
	 */
	private function handleAjaxRequest($content = "", $css = "", $js = "")
	{
		$array = array(
			"title" => $this->title.$this->CI->config->item('title'),
			"content" => $content,
			"js" => $js,
			"css" => $css,
			"slider" => $this->isSliderShown(),
			"language" => $this->CI->language->getClientData()
		);

		return json_encode($array);
	}

	/**
	 * Display the global announcement message
	 */
	private function handleAnnouncement()
	{
		$data = array(
			'module' => 'default',
			'title' => $this->CI->config->item("title"),
			'headline' => $this->CI->config->item("message_headline"),
			'message' => $this->CI->config->item("message_text"),
			'size' => $this->CI->config->item('message_headline_size')
		);

		$output = $this->loadPage("message.tpl", $data);

		return $output;
	}

	/**
	 * Gets the modals
	 * @return mixed
	 */
	private function getModals()
	{
		$modal_data = array(
			'url' => $this->page_url,
			'vote_reminder' => $this->CI->config->item('vote_reminder'),
			'vote_reminder_image' => $this->CI->config->item('vote_reminder_image')
		);

		// Load the modals
		$modals = $this->CI->smarty->view($this->theme_path."views/modals.tpl", $modal_data, true);

		return $modals;
	}

	/**
	 * Gets the header completely loaded.
	 * @param string $css
	 * @param string $js
	 * @return mixed
	 */
	private function getHeader($css = "", $js = "")
	{
		// Gather the header data
		$header_data = array(
			"style_path" => $this->style_path,
			"theme_path" => $this->theme_path,
			"image_path" => $this->image_path,
			"url" => $this->page_url,
			"title" => $this->title . $this->CI->config->item('title'),
			"slider_interval" => $this->CI->config->item('slider_interval'),
			"slider_style" => $this->CI->config->item('slider_style'),
			"vote_reminder" => $this->voteReminder(),
			"keywords" => ($this->custom_keywords) ? $this->custom_keywords : $this->CI->config->item("keywords"),
			"description" => ($this->custom_description) ? $this->custom_description : $this->CI->config->item("description"),
			"menu_top" => $this->getMenu("top"),
			"menu_side" => $this->getMenu("side"),
			"path" => base_url() . APPPATH,
			"favicon" => $this->theme_data['favicon'],
			"cdn_link" => $this->CI->config->item('cdn_enabled') === true ? $this->CI->config->item('cdn_link') : null,
			"extra_css" => $css,
			"extra_js" => $js,
			"analytics" => $this->CI->config->item('analytics'),
			"use_fcms_tooltip" => $this->CI->config->item('use_fcms_tooltip'),
			"slider" => $this->theme_data['slider_text'],
			"slider_id" => $this->theme_data['slider_id'],
			"csrf_cookie" => $this->CI->input->cookie('csrf_token_name'),
			"client_language" => $this->CI->language->getClientData(),
			"activeLanguage" => $this->CI->language->getLanguage()
		);

		// Load the theme
		return $this->CI->smarty->view($this->view_path."header.tpl", $header_data, true);
	}

	/**
	 * Determinate whether or not we should show the vote reminder popup
	 * @return String
	 */
	private function voteReminder()
	{
		if($this->CI->config->item('vote_reminder') && !$this->CI->input->cookie("vote_reminder"))
		{
			$this->CI->input->set_cookie("vote_reminder", "1", $this->CI->config->item('reminder_interval'));
			
			return true;
		}

		return false;
	}

	/**
	 * Loads the sideboxes, and returns the result
	 * @return array
	 */
	public function loadSideboxes()
	{
		require_once("application/interfaces/sidebox.php");
		
		$out = array();

		$sideboxes_db = $this->CI->cms_model->getSideboxes();

		// If we got sideboxes
		if($sideboxes_db)
		{
			// Go through them all and add them to the output.
			foreach($sideboxes_db as $sidebox)
			{
				if($sidebox['permission'] && !hasViewPermission($sidebox['permission'], "--SIDEBOX--"))
				{
					continue;
				}

				$fileLocation = 'application/modules/sidebox_'.$sidebox['type'].'/controllers/'.$sidebox['type'].'.php';

				if(file_exists($fileLocation))
				{
					require_once($fileLocation);

					if($sidebox['type'] == 'custom')
					{
						$object = new $sidebox['type']($sidebox['id']);
					}
					else
					{
						$object = new $sidebox['type']();
					}

					// Add the sidebox to the output.
					array_push($out, array('name' => langColumn($sidebox['displayName']), 'data' => $object->view()));
				}
				else
				{
					array_push($out, array('name' => "Oops, something went wrong", 'data' => 'The following sidebox module is missing or contains an invalid module structure: <b>sidebox_'.$sidebox['type'].'</b>'));
				}
			}
		}
		
		return $out;
	}

	/**
	 * Load a page template
	 * @param String $page Filename
	 * @param Array $data Array of additional template data
	 * @return String
	 */
	public function loadPage($page, $data = array())
	{
		// Get the module, we need to check if it's enabled first
		$data['module'] = array_key_exists("module", $data) ? $data['module'] : $this->module_name;

		// Get the rest of the data
		$data['url'] = array_key_exists("url", $data) ? $data['url'] : $this->page_url;
		$data['theme_path'] = array_key_exists("theme_path", $data) ? $data['theme_path'] : $this->theme_path;
		$data['image_path'] = array_key_exists("image_path", $data) ? $data['image_path'] : $this->image_path;
		$data['CI'] = array_key_exists("CI", $data) ? $data['CI'] : $this->CI;

		// Should we load from the default views or not?
		if($data['module'] == "default")
		{
			// Shorthand for loading views/page.tpl
			$page = ($page == "page.tpl") ? "views/page.tpl" : $page;

			return $this->CI->smarty->view($this->theme_path . $page, $data, true, true);
		}

		// Consruct the path
		$themeView = "application/" . $this->theme_path . "modules/" . $data['module'] . "/" . $page;
			
		// Check if this theme wants to replace our view with it's own
		if(file_exists($themeView))
		{
			return $this->CI->smarty->view($themeView, $data, true);
		}

		return $this->CI->smarty->view('modules/'.$data['module'].'/views/'.$page, $data, true);
	}

	/**
	 * Shorthand for loading a content box
	 * @param String $title
	 * @param String $body
	 * @param Boolean $full
	 * @return String
	 */
	public function box($title, $body, $full = false, $css = false, $js = false)
	{
		$data = array(
			"module" => "default",
			"headline" => $title,
			"content" => $body
		);

		$page = $this->loadPage("page.tpl", $data);

		if($full)
		{
			$this->view($page, $css, $js);
		}

		return $page;
	}
	
	/**
	 * Get the menu links
	 * @param Int $side ID of the specific menu
	 */
	public function getMenu($side = "top") 
	{
		$result = array();

		// Get the database values
		$links = $this->CI->cms_model->getLinks($side);

		foreach($links as $key => $item)
		{
			if(!hasViewPermission($links[$key]['permission'], "--MENU--") && $links[$key]['permission'])
			{
				continue;
			}

			// Xss protect out names
			$links[$key]['name'] = $this->format(langColumn($links[$key]['name']), false, false);

			// Hard coded PM count
			if($links[$key]['link'] == "messages")
			{
				$count = $this->CI->cms_model->getMessagesCount();

				if($count > 0)
				{
					$links[$key]['name'] .= " <b>(".$count.")</b>";
				}
			}

			if(!preg_match("/^\/|[a-z][a-z0-9+\-.]*:/i", $links[$key]['link']))
			{
				 $links[$key]['link'] = $this->page_url . $links[$key]['link'];
			}

			// Append if it's a direct link or not
			$links[$key]['link'] = 'href="'.$links[$key]['link'].'" direct="'.$links[$key]['direct_link'].'"';

			array_push($result, $links[$key]);
		}

		return $result;
	}

	/**
	 * Load the image slider
	 */
	public function getSlider()
	{
		// Load the slides from the database
		$slides_arr = $this->CI->cms_model->getSlides();

		foreach($slides_arr as $key=>$image)
		{
			if(!preg_match("/http:\/\//i", $image['link']) || !preg_match("/https:\/\//i", $image['link']))
			{
				$slides_arr[$key]['link'] = $this->page_url . $image['link'];
			}

			$slides_arr[$key]['text'] = langColumn($image['text']);

			// Replace {path} by the theme image path
			$slides_arr[$key]['image'] = preg_replace("/\{path\}/", $this->image_path, $image['image']);
		}
		
		return $slides_arr;
	}

	/**
	 * Show the 404 error
	 */
	public function show404()
	{
		if($this->CI->input->get('is_acp'))
		{
			header('HTTP/1.0 404 Not Found');
		}

		$this->setTitle(lang("404_title", "error"));

		$message = $this->loadPage("error.tpl", array('module' => 'error', 'is404' => true));
		$output = $this->box(lang("404", "error"), $message);

		$this->view($output);
	}

	/**
	 * Show an error message
	 * @param String $error
	 */
	public function showError($error = false)
	{
		$message = $this->loadPage("error.tpl", array('module' => 'error', 'errorMessage' => $error));
		$output = $this->box($error, $message);

		$this->view($output);
	}

	/**
	 * Returns true if $a >= $b
	 * @param String $a
	 * @param String $b
	 * @param Boolean $notEqual
	 * @return Boolean
	 */
	public function compareVersions($a, $b, $notEqual = false)
	{
		$maxLength = 4;

		$a = preg_replace("/\./", "", $a);
		$b = preg_replace("/\./", "", $b);

		// Add ending zeros if necessary
		if(strlen($a) < $maxLength)
		{

			for($i = 0; $i <= ($maxLength - strlen($a)); $i++)
			{
				$a .= "0";
			}
		}

		// Add ending zeros if necessary
		if(strlen($b) < $maxLength)
		{
			for($i = 0; $i <= ($maxLength - strlen($b)); $i++)
			{
				$b .= "0";
			}
		}

		if($notEqual)
		{
			return (int)$a > (int)$b;
		}
		else
		{
			return (int)$a >= (int)$b;
		}
	}

	/**
	 * Format text
	 * @param String $text
	 * @param Boolean $nl2br
	 * @param Boolean $smileys
	 * @param Boolean $xss
	 * @param Mixed $break
	 */
	public function format($text, $nl2br = false, $smileys = true, $xss = true, $break = false)
	{
		// Prevent Cross Site Scripting
		if($xss && is_string($text))
		{
			$text = $this->CI->security->xss_clean($text);
			$text = htmlspecialchars($text);
		}

		// Wordwrap
		if($break)
		{
			$text = wordwrap($text, $break, "<br />", true);
		}

		// Convert new lines to <br>
		if($nl2br)
		{
			$text = nl2br($text);
		}

		// Show emoticons
		if($smileys)
		{
			$text = parse_smileys($text, base_url().$this->CI->config->item('smiley_path'));
		}

		return $text;
	}

	/**
	 * Format time as "XX days/hours/minutes/seconds"
	 * @param Int $time
	 * @return String
	 */
	public function formatTime($time)
	{
		if(!is_numeric($time))
		{
			return "Not a number";
		}

		$a = array(
			30 * 24 * 60 * 60       => 'month',
			24 * 60 * 60            =>  'day',
			60 * 60                 =>  'hour',
			60                      =>  'minute',
			1                       =>  'second'
		);
		
		foreach($a as $secs => $str)
		{
			$d = $time / $secs;

			if($d >= 1)
			{
				$r = round($d);

				return $r . ' ' . ($r > 1 ? lang($str.'s') : lang($str));
			}
		}
	}

	/**
	 * Gets the domain name we are on
	 * @return mixed
	 */
	public function getDomainName()
	{
		return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/","$1", $this->CI->config->slash_item('base_url'));
	}

	/**
	 * Getter for the title
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Add an extra page title
	 * @param String $title
	 */
	public function setTitle($title)
	{
		$this->title = $title . " - ";
	}

	/**
	 * Add an extra description
	 * @param String $description
	 */
	public function setDescription($description)
	{
		$this->custom_description = $description;
	}

	/**
	 * Add extra keywords
	 * @param String $keywords
	 */
	public function setKeywords($keywords)
	{
		$this->custom_keywords = $keywords;
	}

    /**
     * Get the module id
     * @return int
     */
    public function getModuleId()
	{
		$module = $this->CI->cms_model->getModuleByName($this->CI->template->module_name);

		return $module['id'];
	}

    /**
     * Get the module name
     * @return string
     */
    public function getModuleName()
    {
        return $this->module_name;
    }
}
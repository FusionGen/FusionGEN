<?php

class Settings extends MX_Controller
{
	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');

		parent::__construct();
		
		$this->load->config('smtp');
		$this->load->config('performance');

		require_once('application/libraries/configeditor.php');

		requirePermission("editSystemSettings");
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("Settings");

		$config['title'] = $this->config->item('title');
		$config['server_name'] = $this->config->item('server_name');
		$config['realmlist'] = $this->config->item('realmlist');
		$config['disabled_expansions'] = $this->config->item('disabled_expansions');
		$config['keywords'] = $this->config->item('keywords');
		$config['description'] = $this->config->item('description');
		$config['analytics'] = $this->config->item('analytics');
		$config['vote_reminder'] = $this->config->item('vote_reminder');
		$config['vote_reminder_image'] = $this->config->item('vote_reminder_image');
		$config['reminder_interval'] = $this->config->item('reminder_interval');
		$config['has_smtp'] = $this->config->item('has_smtp');
		$config['cdn'] = $this->config->item('cdn');

		// Performance
		$config['disable_visitor_graph'] = $this->config->item('disable_visitor_graph');

		// SMTP
		$smtp['use_own_smtp_settings'] = $this->config->item('use_own_smtp_settings');
		$smtp['smtp_host'] = $this->config->item('smtp_host');
		$smtp['smtp_user'] = $this->config->item('smtp_user');
		$smtp['smtp_pass'] = $this->config->item('smtp_pass');
		$smtp['smtp_port'] = $this->config->item('smtp_port');

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'realms' => $this->realms->getRealms(),
			'emulators' => $this->getEmulators(),
			'config' => $config,
			'smtp' => $smtp
		);

		// Load my view
		$output = $this->template->loadPage("settings.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('Settings', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/admin/js/settings.js");
	}

	private function getEmulators()
	{
		require("application/config/emulator_names.php");

		return $emulators;
	}

	public function saveWebsite()
	{
		$fusionConfig = new ConfigEditor("application/config/fusion.php");

		$fusionConfig->set('title', $this->input->post('title'));
		$fusionConfig->set('server_name', $this->input->post('server_name'));
		$fusionConfig->set('realmlist', $this->input->post('realmlist'));
		$fusionConfig->set('keywords', $this->input->post('keywords'));
		$fusionConfig->set('description', $this->input->post('description'));
		$fusionConfig->set('analytics', $this->input->post('analytics'));
		$fusionConfig->set('vote_reminder', $this->input->post('vote_reminder'));
		$fusionConfig->set('vote_reminder_image', $this->input->post('vote_reminder_image'));
		$fusionConfig->set('reminder_interval', $this->input->post('reminder_interval') * 60 * 60);
		$fusionConfig->set('cdn', $this->input->post('cdn'));
		$fusionConfig->set('has_smtp', $this->input->post('has_smtp'));

		switch($this->input->post('disabled_expansions'))
		{
			case "legr":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Battle for Azeroth"));
			break;
			case "leg":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Legion Allied Races"), $this->realms->getEmulator()->getExpansionId("Battle for Azeroth"));
			break;
			case "wod":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Legion"), $this->realms->getEmulator()->getExpansionId("Legion Allied Races"));
			break;
			case "mop":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Warlords of Draenor"), $this->realms->getEmulator()->getExpansionId("Legion"));
			break;
			case "cata":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Mists of Pandaria"), $this->realms->getEmulator()->getExpansionId("Warlords of Draenor"));
			break;
			case "wotlk":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("Cataclysm"), $this->realms->getEmulator()->getExpansionId("Mists of Pandaria"), $this->realms->getEmulator()->getExpansionId("Warlords of Draenor"), $this->realms->getEmulator()->getExpansionId("Legion"), $this->realms->getEmulator()->getExpansionId("Legion Allied Races"), $this->realms->getEmulator()->getExpansionId("Battle for Azeroth"));
			break;
			case "tbc":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("WotLK"), $this->realms->getEmulator()->getExpansionId("Cataclysm"), $this->realms->getEmulator()->getExpansionId("Mists of Pandaria"), $this->realms->getEmulator()->getExpansionId("Warlords of Draenor"), $this->realms->getEmulator()->getExpansionId("Legion"), $this->realms->getEmulator()->getExpansionId("Legion Allied Races"), $this->realms->getEmulator()->getExpansionId("Battle for Azeroth"));
			break;
			case "none":
				$disabled_expansions = array($this->realms->getEmulator()->getExpansionId("TBC"), $this->realms->getEmulator()->getExpansionId("WotLK"), $this->realms->getEmulator()->getExpansionId("Cataclysm"), $this->realms->getEmulator()->getExpansionId("Mists of Pandaria"), $this->realms->getEmulator()->getExpansionId("Warlords of Draenor"), $this->realms->getEmulator()->getExpansionId("Legion"), $this->realms->getEmulator()->getExpansionId("Legion Allied Races"), $this->realms->getEmulator()->getExpansionId("Battle for Azeroth"));
			break;
			default:
				$disabled_expansions = array();
			break;
		}

		$fusionConfig->set('disabled_expansions', $disabled_expansions);
		
		$fusionConfig->save();

		die('yes');
	}

	public function savePerformance()
	{
		$fusionConfig = new ConfigEditor("application/config/performance.php");

		$fusionConfig->set('disable_visitor_graph', $this->input->post('disable_visitor_graph'));
		
		$fusionConfig->save();

		die('yes');
	}

	public function saveSmtp()
	{
		$fusionConfig = new ConfigEditor("application/config/smtp.php");

		$fusionConfig->set('use_own_smtp_settings', $this->input->post('use_own_smtp_settings'));
		$fusionConfig->set('smtp_host', $this->input->post('smtp_host'));
		$fusionConfig->set('smtp_user', $this->input->post('smtp_user'));
		$fusionConfig->set('smtp_pass', $this->input->post('smtp_pass'));
		$fusionConfig->set('smtp_port', $this->input->post('smtp_port'));
		
		$fusionConfig->save();

		die('yes');
	}
}
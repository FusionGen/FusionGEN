<?php

class Donate extends MX_Controller
{
	function __construct()
	{
		//Call the constructor of MX_Controller
		parent::__construct();
		
		//Make sure that we are logged in
		$this->user->userArea();

		$this->load->config('donate');
	}
	
	public function index()
	{
		requirePermission("view");

		$this->template->setTitle(lang("donate_title", "donate"));

		$donate_paypal = $this->config->item('donate_paypal');
		$donate_paygol = $this->config->item('donate_paygol');
		
		$user_id = $this->user->getId();
		
		$data = array(
			"donate_paypal" => $donate_paypal, 
			"donate_paygol" => $donate_paygol,
			"user_id" => $user_id,
			"server_name" => $this->config->item('server_name'),
			"currency" => $this->config->item('donation_currency'),
			"currency_sign" => $this->config->item('donation_currency_sign'),
			"multiplier" => $this->config->item('donation_multiplier'),
			"multiplier_paygol" => $this->config->item('donation_multiplier_paygol'),
			"url" => pageURL
		);

		$output = $this->template->loadPage("donate.tpl", $data);

		$this->template->box("<span style='cursor:pointer;' onClick='window.location=\"".$this->template->page_url."ucp\"'>".lang("ucp")."</span> &rarr; ".lang("donate_panel", "donate"), $output, true, "modules/donate/css/donate.css", "modules/donate/js/donate.js");
	}

	public function success()
	{
		$this->user->getUserData();

		$page = $this->template->loadPage("success.tpl", array('url' => $this->template->page_url));

		$this->template->box(lang("donate_thanks", "donate"), $page, true);
	}
}

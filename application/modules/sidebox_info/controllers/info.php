<?php

class Info extends MX_Controller
{
	public function view()
	{
		$data = array(
			"module" => "sidebox_info",
			"url" => $this->template->page_url,
			"currentIp" => $this->input->ip_address(),
			"lastIp" => $this->user->getLastIp(),
			"vp" => $this->user->getVp(),
			"dp" => $this->user->getDp(),
			"expansion" => $this->realms->getEmulator()->getExpansionName($this->user->getExpansion())
		);
					
		$page = $this->template->loadPage("info.tpl", $data);

		return $page;
	}
}

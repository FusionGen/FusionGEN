<?php

class Expansion extends MX_Controller
{
	private $out;
	
	function __construct()
	{
		parent::__construct();
		
		$this->user->userArea();
		
		$this->load->helper('form');

		if(count($_POST) > 0)
		{
			$this->out = $this->changeExpansion($this->input->post('expansion'));
		}
	}
	
	public function index()
	{
		requirePermission("canChangeExpansion");

		$this->template->setTitle(lang("change_expansion", "ucp"));

		if(isset($this->out))
		{
			//We submitted our form already, show the output.
			$this->template->view($this->template->loadPage("page.tpl", array(
				"module" => "default", 
				"headline" => breadcumb(array(
										"ucp" => lang("ucp"),
										"ucp/expansion" => lang("change_expansion", "ucp")
									)), 
				"content" => $this->out
			)));
		}
		else 
		{
			$data = array("expansions" => $this->realms->getExpansions(), "my_expansion" => $this->user->getExpansion());

			$page_data = array(
				"module" => "default", 
				"headline" => breadcumb(array(
								"ucp" => lang("ucp"),
								"ucp/expansion" => lang("change_expansion", "ucp")
							)), 
				"content" => $this->template->loadPage("change_expansion.tpl", $data),
			);

			//Load the template form
			$this->template->view($this->template->loadPage("page.tpl", $page_data));
		}
		
	}

	/**
	 * Change the expansion to the given one.
	 * @param string $expansion
	 * @return string
	 */
	public function changeExpansion($expansion = "")
	{
		// Check for the permission
		requirePermission("canChangeExpansion");

		if(array_key_exists($expansion, $this->realms->getExpansions()))
		{
			//Change the expansion.
			$this->user->setExpansion($expansion);

			$this->plugins->onSetExpansion($this->user->getId(), $expansion);
			
			return "<center style='margin:10px;font-weight:bold;'>".lang("expansion_changed", "ucp")." <a href='".$this->template->page_url."ucp'>".lang("back_to_ucp", "ucp")."</a></center>";
		}

		return "".lang("invalid_expansion", "ucp")."";
	}
}

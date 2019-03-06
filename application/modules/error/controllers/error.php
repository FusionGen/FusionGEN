<?php

class Error extends MX_Controller
{
	public function index()
	{
		$this->template->show404();
	}
}

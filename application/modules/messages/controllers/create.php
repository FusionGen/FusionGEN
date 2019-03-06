<?php

class Create extends MX_Controller
{
	private $removeTools;

	/**
	 * Load model and make sure we're logged in
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load our model
		$this->load->model('messages/create_model');
		$this->load->library('fusioneditor');

		// Make sure they are logged in
		$this->user->userArea();

		requirePermission("view");
		requirePermission("compose");

		$this->removeTools = array("size", "image", "color", "left", "center", "right", "html");
	}
	
	/**
	 * Display the compose page
	 * @param String $username
	 */
	public function index($username = false)
	{
		// Pass some language strings to the client
		clientLang("message_limit", "messages");
		clientLang("title_limit", "messages");
		clientLang("recipient_empty", "messages");
		clientLang("invalid_recipient", "messages");
		clientLang("sent", "messages");
		clientLang("the_inbox", "messages");
		clientLang("error", "messages");
		clientLang("title_cant_be_empty", "messages");

		$this->template->setTitle(lang("compose", "messages"));
		
		// Load the create view
		$data = array(
					"username" => ($username) ? $this->user->getNickname($username) : '',
					"editor" => $this->fusioneditor->create("pm_editor", $this->removeTools),
					"url" => $this->template->page_url
				);

		$content = $this->template->loadPage("create.tpl", $data);

		// Define our box values
		$page_data = array(
				"module" => "default", 
				"headline" => "<span style='cursor:pointer;' onClick='window.location=\"".$this->template->page_url."messages\"'>".lang("messages", "messages")."</span> &rarr; ".lang("compose", "messages"), 
				"content" => $content
			);

		// Load the box
		$page = $this->template->loadPage("page.tpl", $page_data);
		
		// View our content
		$this->template->view($page, "modules/messages/css/create.css", "modules/messages/js/create.js");
	}

	/**
	 * Add the message to the database
	 * @param String $username
	 */
	public function submit($username = false)
	{
		// Username must be set
		if($username == false)
		{
			die("no username");
		}

		$content = $this->input->post('content');
		$title = $this->input->post('title');

		// Message must be set and more than 3 characters
		if(!$content || strlen($content) <= 3)
		{
			die("content length");
		}

		$user_id = $this->internal_user_model->getIdByNickname($username);

		// You can't send it to yourself
		if($user_id == $this->user->getId())
		{
			die("yourself");
		}

		if(empty($user_id))
		{
			die("invalid user");
		}
		
		// Compile it into BBcode
		$content = $this->fusioneditor->compile($content, $this->removeTools);

		// Add it to the database
		$this->create_model->insertMessage($user_id, $this->user->getId(), $title, $content);

		$this->plugins->onCreate($user_id, $this->user->getId(), $title, $content);
		
		// Clear the sender and receiver's PM cache
		$this->cache->delete('messages/'.$user_id."_*");
		$this->cache->delete('messages/'.$this->user->getId()."_*");

		die('sent');
	}
	
	public function check($username = false)
	{
		if(!$username)
		{
			die();
		}

		$results = $this->create_model->getUsersLike($username);

		if(!$results)
		{
			$json = array(
					'status' => 0,
					'exact' => false,
					'users' => array()
				);
		}
		elseif($results === true)
		{
			$json = array(
					'status' => 1,
					'exact' => true,
					'users' => array($username)
				);
		}
		else
		{
			$json = array(
					'status' => 1,
					'exact' => false,
					'users' => $results
				);
		}

		die(json_encode($json));
	}
}
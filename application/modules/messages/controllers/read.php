<?php

class Read extends MX_Controller
{
	private $removeTools;
	
	public function __construct()
	{
		parent::__construct();
		
		// Load resources
		$this->load->model('messages/read_model');
		$this->load->library('fusioneditor');

		// Make sure they are logged in
		$this->user->userArea();

		requirePermission("view");

		// Define which tools to remove for the editor
		$this->removeTools = array("size", "image", "color", "left", "center", "right", "html");
	}

	public function index($id = false)
	{
		clientLang("inbox", "messages");
		
		// Make sure ID is set and is a number
		if(!$id || !is_numeric($id))
		{
			redirect('messages');
		}

		// Get the messages
		$messages = $this->read_model->getMessages($id);
		$title = "";

		if($messages)
		{
			$userId = ($messages[0]['sender_id'] == $this->user->getId()) ? $messages[0]['user_id'] : $messages[0]['sender_id'];
			$userName = $this->user->getNickname($userId);
			$title = lang("conversation_between", "messages")." &amp; ".$userName;

			$this->read_model->markRead($this->user->getId(), $userId);
			$this->cache->delete('messages/'.$this->user->getId()."_*");

			$myAvatar = $this->user->getAvatar();
			$hisAvatar = $this->user->getAvatar($userId);

			foreach($messages as $key => $value)
			{
				$messages[$key]['avatar'] = ($value['sender_id'] == $this->user->getId()) ? $myAvatar : $hisAvatar;
				$messages[$key]['name'] = ($value['sender_id'] == $this->user->getId()) ? lang("you", "messages") : $userName;
				$messages[$key]['message'] = $this->fusioneditor->parse($value['message'], $this->removeTools);
			}

			$this->plugins->onRead($messages);
		}

		$data = array(
			'messages' => $messages,
			'url' => $this->template->page_url,
			'me' => $this->user->getId(),
			'editor' => $this->fusioneditor->create("pm_editor", $this->removeTools, 150),
			"him" => ((!$messages) ? $this->user->getId() : $userId),
			'myAvatar' => $this->user->getAvatar()
		);

		$pm_page = $this->template->loadPage("read.tpl", $data);

		$page_data = array(
			"module" => "default", 
			"headline" => "<span style='cursor:pointer;' onClick='window.location=\"".$this->template->page_url."messages\"'>".lang("messages", "messages")."</span> &rarr; ". ((!$messages) ? lang("not_found", "messages"): $title), 
			"content" => $pm_page
		);
	
		$page = $this->template->loadPage("page.tpl", $page_data);

		$this->template->view($page, "modules/messages/css/read.css", "modules/messages/js/read.js");
	}

	public function reply($id = false)
	{
		requirePermission("reply");

		if(!$id || $id == $this->user->getId())
		{
			die(lang("enter_recipient", "messages"));
		}

		$content = $this->input->post('content');

		if(!$content && strlen($content) > 3)
		{
			die(lang("enter_message", "messages"));
		}

		// Format title
		$title = $this->read_model->getLastTitle($id);

		if(!preg_match("/Re: /", $title))
		{
			$title = "Re: ".$title;
		}

		// Compile it into BBcode
		$content = $this->fusioneditor->compile($content, $this->removeTools);

		// Add it to the database
		$this->read_model->reply($id, $this->user->getId(), $title, $content);

		$this->plugins->onReply($id, $this->user->getId(), $title, $content);
		
		// Clear the sender and receiver's PM cache
		$this->cache->delete('messages/'.$id."_*");
		$this->cache->delete('messages/'.$this->user->getId()."_*");

		die($this->fusioneditor->parse($content, $this->removeTools));
	}
}
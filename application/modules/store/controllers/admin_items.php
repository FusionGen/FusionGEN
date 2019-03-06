<?php

// todo: NO PERMISSIONS!

class Admin_items extends MX_Controller
{
	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');
		$this->load->model('items_model');

		parent::__construct();

		requirePermission("canViewItems");
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("Items");

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'items' => $this->items_model->getItems(),
			'groups' => $this->items_model->getGroups(),
			'realms' => $this->realms->getRealms()
		);

		// Load my view
		$output = $this->template->loadPage("items.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('Store', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/store/js/admin_items.js");
	}

	/**
	 * Create a group that will group some items.
	 */
	public function createGroup()
	{
		// Check for the permission
		requirePermission("canAddGroups");

		$data["title"] = $this->input->post("title");
		$data["orderNumber"] = $this->input->post("order");

		if(!$data['title'])
		{
			die("UI.alert('The following fields can\'t be empty: [Title]')");
		}

		$this->items_model->addGroup($data);

		$this->cache->delete('store_items.cache');

		// Add log
		$this->logger->createLog('Added item group', $data["title"]);

		$this->plugins->onCreateGroup($data['title']);

		die('window.location.reload(true)');
	}

	/**
	 * Add item
	 */
	public function create()
	{
		// Check for the permission
		requirePermission("canAddItems");

		if($this->input->post("query"))
		{
			$data = $this->getQueryData();
		}
		else if($this->input->post("command"))
		{
			$data = $this->getCommandData();
		}
		else
		{
			$data = $this->getItemData();
		}

		$this->items_model->add($data);

		$this->cache->delete('store_items.cache');

		// Add log
		$this->logger->createLog('Item added', $data['name']);

		$this->plugins->onAddItem($data);

		die('window.location.reload(true)');
	}

	/**
	 * Get the query data
	 * @return mixed
	 */
	private function getQueryData()
	{
		$data["name"] = $this->input->post("name");
		$data["description"] = $this->input->post("description");
		$data["quality"] = $this->input->post("quality");
		$data["query_database"] = $this->input->post("query_database");
		$data["query_need_character"] = ($this->input->post("query_need_character") == "true") ? 1 : 0;
		$data["require_character_offline"] = ($this->input->post("require_character_offline") == "true") ? 1 : 0;
		$data["query"] = $this->input->post("query");
		$data["realm"] = $this->input->post("realm");
		$data["group"] = $this->input->post("group");
		$data["vp_price"] = $this->input->post("vpCost");
		$data["dp_price"] = $this->input->post("dpCost");
		$data["icon"] = $this->input->post("icon");
		$data["tooltip"] = 0;

		if(!preg_match("/inv_.+/i", $data["icon"]))
			$data["icon"] = "inv_misc_questionmark";

		return $data;
	}

	/**
	 * Get the command data
	 * @return mixed
	 */
	private function getCommandData()
	{
		$data["name"] = $this->input->post("name");
		$data["description"] = $this->input->post("description");
		$data["quality"] = $this->input->post("quality");
		$data["command_need_character"] = ($this->input->post("command_need_character") == "true") ? 1 : 0;
		$data["require_character_offline"] = ($this->input->post("require_character_offline") == "true") ? 1 : 0;
		$data["command"] = $this->input->post("command");
		$data["realm"] = $this->input->post("realm");
		$data["group"] = $this->input->post("group");
		$data["vp_price"] = $this->input->post("vpCost");
		$data["dp_price"] = $this->input->post("dpCost");
		$data["icon"] = $this->input->post("icon");
		$data["tooltip"] = 0;

		if(!preg_match("/inv_.+/i", $data["icon"]))
			$data["icon"] = "inv_misc_questionmark";

		return $data;
	}

	/**
	 * Get the itemdata
	 * @return mixed
	 */
	private function getItemData()
	{
		$data["itemid"] = $this->input->post("itemid");
		$data["description"] = $this->input->post("description");
		$data["realm"] = $this->input->post("realm");
		$data["group"] = $this->input->post("group");
		$data["vp_price"] = $this->input->post("vpCost");
		$data["dp_price"] = $this->input->post("dpCost");
		$data["icon"] = $this->input->post("icon");

		if(!is_numeric(preg_replace("/,/", "", $data["itemid"])))
		{
			die("UI.alert('Invalid item ID')");
		}

		if(preg_match("/,/", $data["itemid"]))
		{
			$data["name"] = $this->input->post("name");
			$data["tooltip"] = 0;
			$data["quality"] = 4;
			if(!preg_match("/inv_.+/i", $data["icon"]))
				$data["icon"] = "inv_misc_questionmark";
		}
		else
		{
			$item_data = $this->realms->getRealm($data["realm"])->getWorld()->getItem($data["itemid"]);

			if(!$item_data)
			{
				die("UI.alert('Invalid item')");
			}

			$post_name = $this->input->post('name');
			$data["name"] = $post_name ? $post_name : $item_data['name'];
			$data["tooltip"] = 1;
			$data["quality"] = $item_data['Quality'];
			if(!preg_match("/inv_.+/i", $data["icon"]))
				$data["icon"] = file_get_contents($this->template->page_url."icon/get/".$data["realm"]."/".$data["itemid"]);
		}

		return $data;
	}

	/**
	 * Load the page to edit the item with the given id.
	 * @param bool $id
	 */
	public function edit($id = false)
	{
		// Check for the permission
		requirePermission("canEditItems");

		if(!is_numeric($id) || !$id)
		{
			die();
		}

		$item = $this->items_model->getItem($id);

		if(!$item)
		{
			show_error("There is no item with ID ".$id);

			die();
		}

		// Change the title
		$this->administrator->setTitle($item['name']);

		$data = array(
			'url' => $this->template->page_url,
			'item' => $item,
			'groups' => $this->items_model->getGroups(),
			'realms' => $this->realms->getRealms()
		);

		// Load my view
		$output = $this->template->loadPage("edit_items.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('<a href="'.$this->template->page_url.'store/admin_items">Items</a> &rarr; '.$item['name'], $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/store/js/admin_items.js");
	}

	/**
	 * Save the edited details for the given item id.
	 * @param bool $id
	 */
	public function save($id = false)
	{
		// Check for the permission
		requirePermission("canEditItems");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		if($this->input->post("query"))
		{
			$data = $this->getQueryData();
		}
		else if($this->input->post("command"))
		{
			$data = $this->getCommandData();
		}
		else
		{
			$data = $this->getItemData();
		}

		$this->items_model->edit($id, $data);

		$this->cache->delete('store_items.cache');

		// Add log
		$this->logger->createLog('Edited item', $data['name']);

		$this->plugins->onEditItem($id, $data);

		die('window.location="'.$this->template->page_url.'store/admin_items"');
	}

	/**
	 * Save a group with the given id
	 * @param bool $id
	 */
	public function saveGroup($id = false)
	{
		// Check for the permission
		requirePermission("canEditGroups");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$data["title"] = $this->input->post("title");
		$data["orderNumber"] = $this->input->post("order");

		if(!$data["title"] || !$data["orderNumber"])
		{
			die();
		}

		$this->items_model->editGroup($id, $data);

		// Add log
		$this->logger->createLog('Edited item group', $id);

		$this->plugins->onEditGroup($id);

		$this->cache->delete('store_items.cache');
	}

	public function delete($id = false)
	{
		// Check for the permission
		requirePermission("canRemoveItems");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$this->items_model->delete($id);

		// Add log
		$this->logger->createLog('Deleted item', $id);

		$this->plugins->onDeleteItem($id);

		$this->cache->delete('store_items');
	}

	public function deleteGroup($id = false)
	{
		requirePermission("canRemoveGroups");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$this->items_model->deleteGroup($id);

		// Add log
		$this->logger->createLog('Deleted group', $id);

		$this->plugins->onDeleteGroup($id);

		$this->cache->delete('store_items');
	}
}
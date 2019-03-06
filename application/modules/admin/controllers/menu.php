<?php

class Menu extends MX_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library("administrator");
		$this->load->model("menu_model");

		requirePermission("viewMenuLinks");
	}

	/**
	 * Loads the page
	 */
	public function index()
	{
		//Set the title to menu
		$this->administrator->setTitle("Menu links");
		
		$links = $this->menu_model->getMenuLinks();

		if($links)
		{
			foreach($links as $key => $value)
			{
				// Shorten the link if necessary
				if(strlen($value['link']) > 12)
				{
					$links[$key]['link_short'] = mb_substr($value['link'], 0, 12) . '...';
				}
				else
				{
					$links[$key]['link_short'] = $value['link'];
				}

				// Add the website path if internal link
				if(!preg_match("/https?:\/\//", $value['link']))
				{
					$links[$key]['link'] = $this->template->page_url . $value['link'];
				}

				$links[$key]['name'] = langColumn($links[$key]['name']);

				// Shorten the name if necessary
				if(strlen($links[$key]['name']) > 15)
				{
					$links[$key]['name'] = mb_substr($links[$key]['name'], 0, 15) . '...';
				}
			}
		}

        if ($pages = $this->menu_model->getPages())
        {
    		foreach($pages as $k => $v)
    		{
    			$pages[$k]['name'] = langColumn($v['name']);
    		}
        }

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'links' => $links,
			'pages' => $pages
		);

		// Load my view
		$output = $this->template->loadPage("menu/menu.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('Menu links', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/admin/js/menu.js");
	}
	
	public function create()
	{
		requirePermission("addMenuLinks");

		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$side = $this->input->post('side');
		$direct_link = $this->input->post('direct_link');

		$id = $this->menu_model->add($name, $link, $side, $direct_link);

		if($this->input->post('visibility') == "group")
		{
			$this->menu_model->setPermission($id);
		}

		die('window.location.reload(true)');
	}
	
	public function delete($id)
	{
		requirePermission("deleteMenuLinks");

		if($this->menu_model->delete($id))
		{
			die("success");
		}
		else
		{
			die("An error occurred while trying to delete this menu link.");
		}
		
	}

	public function edit($id = false)
	{
		requirePermission("editMenuLinks");

		if(!is_numeric($id) || !$id)
		{
			die();
		}

		$link = $this->menu_model->getMenuLink($id);
	
		if(!$link)
		{
			show_error("There is no link with ID ".$id);

			die();
		}

		// Change the title
		$this->administrator->setTitle(langColumn($link['name']));

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'link' => $link
		);

		// Load my view
		$output = $this->template->loadPage("menu/edit_menu.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('<a href="'.$this->template->page_url.'admin/menu">Menu links</a> &rarr; '.langColumn($link['name']), $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/admin/js/menu.js");
	}

	public function move($id = false, $direction = false)
	{
		requirePermission("editMenuLinks");

		if(!$id || !$direction)
		{
			die();
		}
		else
		{
			$order = $this->menu_model->getOrder($id);

			if(!$order)
			{
				die();
			}
			else
			{
				if($direction == "up")
				{
					$target = $this->menu_model->getPreviousOrder($order);
				}
				else
				{
					$target = $this->menu_model->getNextOrder($order);
				}

				if(!$target)
				{
					die();
				}
				else
				{
					$this->menu_model->setOrder($id, $target['order']);
					$this->menu_model->setOrder($target['id'], $order);
				}
			}
		}
	}

	public function save($id = false)
	{
		requirePermission("editMenuLinks");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$data['name'] = $this->input->post('name');
		$data['link'] = $this->input->post('link');
		$data['side'] = $this->input->post('side');
		$data['direct_link'] = $this->input->post('direct_link');

		$this->menu_model->edit($id, $data);

		$hasPermission = $this->menu_model->hasPermission($id);

		if($this->input->post('visibility') == "group" && !$hasPermission)
		{
			$this->menu_model->setPermission($id);
		}
		elseif($this->input->post('visibility') != "group" && $hasPermission)
		{
			$this->menu_model->deletePermission($id);
		}

		die('window.location="'.$this->template->page_url.'admin/menu"');
	}
}
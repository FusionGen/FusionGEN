<?php

class Admin extends MX_Controller
{
	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');
		$this->load->model('news_model');
		$this->load->helper('tinymce_helper');

		parent::__construct();

		requirePermission("canViewAdmin");
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("News");

		$articles = $this->news_model->getArticles(true);

		if($articles)
		{
			foreach($articles as $key => $value)
			{
				$articles[$key]['headline'] = langColumn($articles[$key]['headline']);
					
				if(strlen($articles[$key]['headline']) > 20)
				{
					$articles[$key]['headline'] = mb_substr($articles[$key]['headline'], 0, 20) . '...';
				}	

				$articles[$key]['nickname'] = $this->user->getNickname($value['author_id']);
			}
		}

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'news' => $articles
		);

		// Load my view
		$output = $this->template->loadPage("admin.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('News articles', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/news/js/admin.js");
	}

	/**
	 * Edit a news post with the given id.
	 * @param bool $id
	 */
	public function edit($id = false)
	{
		requirePermission("canEditArticle");

		if(!$id || !is_numeric($id))
		{
			die();
		}

		$article = $this->news_model->getArticle($id);

		if($article == false)
		{
			show_error("There is no article with ID ".$id);
			die();
		}

		// Change the title
		$this->administrator->setTitle(langColumn($article['headline']));

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'article' => $article
		);

		// Load my view
		$output = $this->template->loadPage("admin_edit.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('<a href="'.$this->template->page_url.'news/admin">News articles</a> &rarr; '.langColumn($article['headline']), $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/news/js/admin.js");
	}

	public function delete($id = false)
	{
		requirePermission("canRemoveArticle");

		if(!$id)
		{
			die();
		}
		
		$this->cache->delete('news_*.cache');
		$this->news_model->delete($id);

		// Add log
		$this->logger->createLog('Deleted article', $id);

		$this->plugins->onDelete($id);
	}

	public function create($id = false)
	{
		requirePermission("canAddArticle");

		$headline = $this->input->post('headline');
		$avatar = $this->input->post('avatar');
		$comments = $this->input->post('comments');
		$content = $this->input->post('content');

		if(strlen($headline) > 70 || empty($headline))
		{
			die("The headline must be between 1-70 characters long");
		}

		if(empty($content))
		{
			die("Content can't be empty");
		}

		if(in_array($comments, array("1", "yes", "true")))
		{
			$comments = "0";
		}
		else
		{
			$comments = "-1";
		}

		if(in_array($avatar, array("1", "yes", "true")))
		{
			$avatar = $this->user->getAvatar();
		}
		else
		{
			$avatar = "";
		}

		if($id)
		{
			$this->news_model->update($id, $headline, $avatar, $comments, $content);

			// Add log
			$this->logger->createLog('Edited article', $headline);

			$this->plugins->onUpdate($id, $headline, $content, $avatar, $comments);
		}
		else
		{
			$this->news_model->create($headline, $avatar, $comments, $content);

			// Add log
			$this->logger->createLog('Created article', $headline);

			$this->plugins->onCreate($headline, $content, $avatar, $comments);
		}

		$this->cache->delete('news_*.cache');

		die("yes");
	}
}
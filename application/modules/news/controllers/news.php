<?php

class News extends MX_Controller
{
	private $news_articles = array();
	private $startIndex = 0;
	
	public function __construct()
	{
		// Call the constructor of MX_Controller
		parent::__construct();	
		
		$this->load->config('news');
		$this->load->library('pagination');
		$this->load->model('news_model');
		$this->load->model('comments_model');
	}

	public function sortByDate($a, $b)
	{
		return $b['timestamp'] - $a['timestamp'];
	}

	/**
	 * Default to page 1
	 */
	public function index()
	{
		requirePermission("view");

		if($this->config->item('news_internal'))
			$this->getNews();

		if($this->config->item('news_external'))
			foreach($this->plugins->getNews() as $plugin=>$data)
				if($data != false)
					$this->news_articles = array_merge($this->news_articles, $data);

		usort($this->news_articles, array($this, "sortByDate"));

		// Show the page
		$this->displayPage();
	}

	public function rss()
	{
		requirePermission("view");

		// HACK FIX: Wipe the output buffer, because something is placing a tab in it.
		ob_end_clean();

		// Load the XML helper
		$this->load->helper('xml');

		// Get the articles with the upper limit decided by our config.
		$this->news_articles = $this->news_model->getArticles(0, $this->config->item('news_limit'));

		// For each key we need to add the special values that we want to print
		foreach($this->news_articles as $key => $article)
		{
			$this->news_articles[$key]['title'] = xml_convert(langColumn($article['headline']));
			$this->news_articles[$key]['content'] = xml_convert(langColumn($article['content']));
			$this->news_articles[$key]['link'] = base_url().'news/view/'.$article['id'];
			$this->news_articles[$key]['date'] = date(DATE_RSS, $article['timestamp']);
			$this->news_articles[$key]['author'] = $this->user->getNickname($article['author_id']);
			$this->news_articles[$key]['tags'] = $this->news_model->getTags($article['id']);
		}

		$data['link'] = $this->config->site_url();
		$data['domain'] = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		$data['feed_url'] = base_url().'news/rss';
		$data['page_description'] = $this->config->item('rss_description');
		$data['page_language'] = $this->config->item('rss_lang');
		$data['articles'] = $this->news_articles;

		header('Content-Type: text/xml; charset=UTF-8');
		echo $this->template->loadPage('rss.tpl', $data);
	}

	public function view($id)
	{
		requirePermission("canViewSpecificArticle");

		// if it's not an int or the article doesn't exist, load the index page.
		if(!$this->news_model->articleExists($id))
		{
			$this->index();
			return;
		}
			
		// Get the cache
		$cache = $this->cache->get("news_id".$id."_".getLang());

		// Check if cache is valid
		if($cache !== false)
		{
			$this->template->view($cache, "modules/news/css/news.css", "modules/news/js/ajax.js");
		}
		else
		{
			// Get the article passed
			$this->news_articles = $this->template->format(array($this->news_model->getArticle($id)));

			// For each key we need to add the special values that we want to print
			foreach($this->news_articles as $key=>$article)
			{
				$this->news_articles[$key]['headline'] = langColumn($article['headline']);
				$this->news_articles[$key]['content'] = langColumn($article['content']);
				$this->news_articles[$key]['date'] = date("Y/m/d", $article['timestamp']);
				$this->news_articles[$key]['author'] = $this->user->getNickname($article['author_id']);
				$this->news_articles[$key]['link'] = ($article['comments'] == -1)? '' : "href='javascript:void(0)' onClick='Ajax.showComments(".$article['id'].")'";
				$this->news_articles[$key]['comments_id'] = "id='comments_".$article['id']."'";
				$this->news_articles[$key]['comments_button_id'] = "id='comments_button_".$article['id']."'";
				$this->news_articles[$key]['tags'] = $this->news_model->getTags($id);
			}

			$content = $this->template->loadPage("articles.tpl", array("articles" => $this->news_articles, 'url' => $this->template->page_url, "pagination" => ''));
			$content .= $this->template->loadPage("expand_comments.tpl", array("article" => $this->news_articles[0], 'url' => $this->template->page_url));
			$this->cache->save("news_id".$id."_".getLang(), $content);

			// Load the template and pass the page content
			$this->template->view($content, "modules/news/css/news.css", "modules/news/js/ajax.js");
		}
	}
	
	private function displayPage()
	{
		// Get the cache
		$cache = $this->cache->get("news_".$this->startIndex."_".getLang());
		
		// Check if cache is valid
		if($cache !== false)
		{
			$this->template->view($cache, "modules/news/css/news.css", "modules/news/js/ajax.js");
		}
		else
		{
			$content = $this->template->loadPage("articles.tpl", array(
				"articles" => $this->news_articles,
				'url' => $this->template->page_url,
				"pagination" => $this->pagination->create_links(),
				'single' => false)
			);

			$this->cache->save("news_".$this->startIndex."_".getLang(), $content);

			// Load the template and pass the page content
			$this->template->view($content, "modules/news/css/news.css", "modules/news/js/ajax.js");
		}
	}
	
	private function getNews()
	{
		// Init pagination
		$config = $this->initPagination();
	
		// Decide our starting index of the news
		$this->startIndex = $this->uri->segment($config['uri_segment']);
		
		if(empty($this->startIndex))
		{
			$this->startIndex = 0;
		}

		// Get the articles with the lower and upper limit decided by our pagination.
		$this->news_articles = $this->news_model->getArticles((int)$this->startIndex, ((int)$this->startIndex + $config['per_page']));

		// For each key we need to add the special values that we want to print
		foreach($this->news_articles as $key => $article)
		{
			$this->news_articles[$key]['headline'] = langColumn($article['headline']);
			$this->news_articles[$key]['content'] = langColumn($article['content']);
			$this->news_articles[$key]['date'] = date("Y/m/d", $article['timestamp']);
			$this->news_articles[$key]['author'] = $this->user->getNickname($article['author_id']);
			$this->news_articles[$key]['link'] = ($article['comments'] == -1)? '' : "href='javascript:void(0)' onClick='Ajax.showComments(".$article['id'].")'";
			$this->news_articles[$key]['comments_id'] = "id='comments_".$article['id']."'";
			$this->news_articles[$key]['comments_button_id'] = "id='comments_button_".$article['id']."'";
			$this->news_articles[$key]['tags'] = $this->news_model->getTags($article['id']);
		}
	}
	
	private function initPagination()
	{
		// Basic configs
		$config['uri_segment'] = '2';
		$config['base_url'] = base_url().'/news';
		$config['total_rows'] = $this->news_model->countArticles();
		$config['per_page'] = $this->config->item('news_limit');
		
		// Tag configs
		$config['full_tag_open'] = '<div id="news_pagination">';
		$config['full_tag_close'] = '</div>';
		
		// Disable last and first tag.
		$config['last_link'] = '';
		$config['first_link'] = '';
		
		// Change next and previous
		$config['next_link'] = 'Older posts &rarr;';
		$config['prev_link'] = '&larr; Newer posts';
		
		// DISABLE THE PAGE NUMBERS
		$config['display_pages'] = FALSE;
		
		
		$this->pagination->initialize($config);
		
		return $config;
	}
}

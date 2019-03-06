<?php

class Facebook extends Plugin
{
	private $news_articles = array();

	public function getNews()
	{
		if(!$this->config['news_by_facebook'])
			return false;

		$facebook_articles = $this->loadFacebookDetails();

		foreach($facebook_articles['data'] as $key=>$article)
		{
			// Make sure that the variables from $article exists
			isset($article['message']) ? $article['message'] = $article['message'] : $article['message'] = 'An error occurred while trying to load this message.';
			isset($article['created_time']) ? $article['created_time'] = date("Y/m/d", strtotime($article['created_time'])) : $article['created_time'] = 'An error occurred while trying to load this time.';
			isset($article['from']['name']) ? $article['from']['name'] = $article['from']['name'] : $article['from']['name'] = 'An error occurred while trying to load this username.';
			isset($article['id']) ? $article['id'] = $article['id'] : $article['id'] = 'An error occurred while trying to load the article id.';
			isset($article['comments']['count']) ? $article['comments']['count'] = $article['comments']['count'] : $article['comments']['count'] = 'An error occurred while trying to load the comment count.';

			// Load them into our array
			$this->news_articles[$key]['date'] = $article['created_time'];
			$this->news_articles[$key]['timestamp'] = strtotime($article['created_time']);
			$this->news_articles[$key]['link'] = "href='javascript:void(0)' onClick='Ajax.showComments(".$article['id'].")'";
			$this->news_articles[$key]['comments_id'] = "id='comments_".$article['id']."'";
			$this->news_articles[$key]['comments_button_id'] = "id='comments_button_".$article['id']."'";
			$this->news_articles[$key]['content'] = isset($article['message']) ? $article['message'] : 'An error occurred while trying to load this message.';
			$this->news_articles[$key]['comments'] = $article['comments']['count'];
			$this->news_articles[$key]['headline'] = mb_substr($article['message'],0,$this->CI->config->item('facebook_headline_length')).' ....';

			// Get the nickname of our poster that we assigned
			$this->news_articles[$key]['author'] = $this->CI->user->getNickname($this->CI->config->item('facebook_user_poster'));
			// Get our poster that we assigned
			$this->news_articles[$key]['author_id'] = $this->CI->config->item('facebook_user_poster');
			// Load the avatar through facebook api and uses SSL return to make sure that we don't break https :P
			$this->news_articles[$key]['avatar'] = 'https://graph.facebook.com/'.$this->CI->config->item('facebook_username').'/picture?type=normal&return_ssl_resources=1';
		}
		
		return $this->news_articles;
	}

	private function loadFacebookDetails()
	{
		// Try to open the facebook url pages.
		try 
		{
			// Save it in news_articles then, also decode the json, also a array!
			$news_articles = file_get_contents('https://graph.facebook.com/'.$this->config['facebook_username'].'/feed/?access_token='.$this->generateAccessToken().'&limit='.$this->CI->config->item('news_limit'));
			$news_articles = json_decode($news_articles, true);
			return $news_articles;
		} catch(Exception $e)
		{
			return $e->getMessage();
		}
	}

	private function generateAccessToken()
	{
		try
		{
			// Get the access token
			$token_line = file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$this->config['facebook_app_id'].'&client_secret='.$this->config['facebook_app_secret']);
			// Extract the right token out of it
			$access_token = mb_substr($token_line, 13, strlen($token_line));
			return $access_token;
		} catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
}
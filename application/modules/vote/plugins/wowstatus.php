<?php

/**
 * wowstatus.net vote postpack
 * described at: http://www.wowstatus.net/?p=FAQ
 *
 * @package FusionCMS
 * @author Maxi Arnicke
 * @link http://fusion-hub.com
 */

require_once(APPPATH.'modules/vote/plugins/classes/VoteCallbackPlugin.php');

class Wowstatus extends VoteCallbackPlugin
{
	public $url = "wowstatus.net";
	public $voteLinkFormat = "{vote_link}&user={user_id}";
	
	protected function checkAccess()
	{
		return $this->CI->input->ip_address() == gethostbyname('wowstatus.net');
	}
	
	protected function readUserId()
	{
		return $this->input->post('user');
	}
}
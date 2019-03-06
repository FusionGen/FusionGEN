<?php

/**
 * openwow.com callback system
 * described at: http://www.openwow.com/misc=callbacks
 *
 * @package FusionCMS
 * @author Maxi Arnicke
 * @link http://fusion-hub.com
 */

require_once(APPPATH.'modules/vote/plugins/classes/VoteCallbackPlugin.php');

class Openwow extends VoteCallbackPlugin
{
	public $url = "openwow.com";
	public $voteLinkFormat = "{vote_link}&spb={user_id}";
	
	protected function checkAccess()
	{
		return $this->CI->input->ip_address() == gethostbyname('openwow.com');
	}
	
	protected function readUserId()
	{
		return $this->CI->input->post('pbid');
	}
}
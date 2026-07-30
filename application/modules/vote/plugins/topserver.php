<?php

/**
 * topserver.live incentive voting
 * described at: https://www.topserver.live/faq
 *
 * @package FusionCMS
 * @author  Haritz Lopez
 * @link    https://www.topserver.live/
 */

require_once(APPPATH . 'modules/vote/plugins/classes/VoteCallbackPlugin.php');

class Topserver extends VoteCallbackPlugin
{
    public $url = "topserver.live";
    public $voteLinkFormat = "{vote_link}/{user_id}";

    protected function checkAccess()
    {
        return $this->CI->input->ip_address() == gethostbyname('topserver.live');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('reward');
    }
}

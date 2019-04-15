<?php

class Discord extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->config('sidebox_discord/discord');
    }

    public function view()
    {
        $data = array(
            "module" => "sidebox_discord",
            "server_id" => $this->config->item('discord_server_id')
        );

        $page = $this->template->loadPage("discord.tpl", $data);
        return $page;
    }
}

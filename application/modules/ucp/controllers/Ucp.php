<?php

class Ucp extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('links');
    }

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("user_panel", "ucp"));

        $data = array(
            "username" => $this->user->getNickname(),
            "expansion" => $this->realms->getEmulator()->getExpansionName($this->external_account_model->getExpansion()),
            "vp" => $this->internal_user_model->getVp(),
            "dp" => $this->internal_user_model->getDp(),
            "url" => $this->template->page_url,
            "location" => $this->internal_user_model->getLocation(),
            "email" => $this->user->getEmail(),
            "groups" => $this->acl_model->getGroupsByUser($this->user->getId()),
            "register_date" => $this->user->getRegisterDate(),
            "status" => $this->user->getAccountStatus(),
            "avatar" => $this->user->getAvatar($this->user->getId()),
            "id" => $this->user->getId(),

            "config" => array(
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "expansion" => $this->config->item('ucp_expansion'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "mod" => $this->config->item('ucp_mod')
            ),

            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "realmObj" => $this->realms,
        );

        $this->template->view($this->template->loadPage("page.tpl", array(
            "module" => "default",
            "headline" => lang("user_panel", "ucp"),
            "content" => $this->template->loadPage("ucp.tpl", $data)
        )), "modules/ucp/css/ucp.css");
    }

    public function characters()
    {
        $characters_data = array(
            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "url" => $this->template->page_url,
            "realmObj" => $this->realms,
            "avatar" => $this->user->getAvatar($this->user->getId()),

            "config" => array(
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "expansion" => $this->config->item('ucp_expansion'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "mod" => $this->config->item('ucp_mod')
            )
        );

        $content = $this->template->loadPage("ucp_characters.tpl", $characters_data);
        $this->template->view($content, "modules/ucp/css/ucp.css");
    }
}

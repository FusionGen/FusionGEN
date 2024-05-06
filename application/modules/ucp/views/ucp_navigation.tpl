{if !isset($link_active)}{$link_active = ""}{/if}

{if $link_active != 'ucp'}<link rel="stylesheet" href="{$url}application/modules/ucp/css/ucp.css">{/if}

<div class="col-lg-4 py-5 pe-lg-5">
	<div class="w-100 text-center mb-5">

		<a href="{$url}ucp/avatar" class="user-avatar">
			<img src="{$CI->user->getAvatar()}" alt="avatar" class="rounded-circle">
			<div class="avatar-change-text">
				{lang("change_avatar", "main")}
			</div>
		</a>

	</div>
	<div class="section-header"></div>
	<div class="section-body mt-3">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-action disabled bg-transparent text-center">Navigation</a>
		</div>

		<div class="list-group">
			<a href="{$url}ucp" class="list-group-item list-group-item-action {if $link_active == 'ucp'}active disabled{/if}">{lang("account_overview", "main")}</a>
			{if hasPermission('canUpdateAccountSettings', 'ucp')}<a href="{$url}ucp/settings" class="list-group-item list-group-item-action {if $link_active == 'settings'}active disabled{/if}">{lang("account_settings", "main")}</a>{/if}
		</div>

		{* <div class="list-group mt-3">
			{if hasPermission('canChangeExpansion', "ucp")}<a href="{$url}ucp/expansion" class="list-group-item list-group-item-action  {if $link_active == 'expansion'}active disabled{/if}">{lang("change_expansion", "main")}</a>{/if}
			{if hasPermission('view', "teleport")}<a href="{$url}teleport" class="list-group-item list-group-item-action  {if $link_active == 'teleport'}active disabled{/if}">{lang("teleport_hub", "main")}</a>{/if}
		</div> *}

		<div class="list-group mt-3">
			{if hasPermission('view', "teleport")}<a href="{$url}teleport" class="list-group-item list-group-item-action  {if $link_active == 'teleport'}active disabled{/if}">{lang("teleport_hub", "main")}</a>{/if}
			{if hasPermission('view', "vote")}<a href="{$url}vote" class="list-group-item list-group-item-action  {if $link_active == 'vote'}active disabled{/if}">{lang("vote", "main")}</a>{/if}
			{if hasPermission('view', "donate")}<a href="{$url}donate" class="list-group-item list-group-item-action  {if $link_active == 'donate'}active disabled{/if}">{lang("donate", "main")}</a>{/if}
			{if hasPermission('view', "store")}<a href="{$url}store" class="list-group-item list-group-item-action  {if $link_active == 'store'}active disabled{/if}">{lang("store", "main")}</a>{/if}
		</div>

		<div class="list-group mt-3">
			{if hasPermission('view', "mod")}<a href="{$url}mod" class="list-group-item list-group-item-action">{lang("mod_panel", "main")}</a>{/if}
			{if hasPermission('view', "admin")}<a href="{$url}admin" class="list-group-item list-group-item-action">{lang("admin_panel", "main")}</a>{/if}
		</div>
	</div>
</div>

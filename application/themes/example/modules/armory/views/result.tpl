<!--[if LT IE 8]>
	<script type="text/javascript">
		function noIE()
		{
			if(typeof UI != "undefined")
			{
				UI.alert("The armory is not fully compatible with Internet Explorer 8 or below!");
			}
			else
			{
				setTimeout(noIE, 100);
			}
		}

		$(document).ready(function()
		{
			noIE();
		});
	</script>
<![endif]-->
	
<div id="search_sections">
	<div id="search_realms">
		{foreach from=$realms item=realm}
			<a href="javascript:void(0)" onClick="Search.toggleRealm({$realm->getId()}, this)" class="search_realm nice_button nice_active">
				{$realm->getName()}
			</a>
		{/foreach}
	</div>

	<a href="javascript:void(0)" onClick="Search.showTab(1, this)" class="search_link {if $show.characters == 'block'}nice_active{/if} nice_button">{lang('characters', 'armory')} ({count($characters)})</a>
	<a href="javascript:void(0)" onClick="Search.showTab(2, this)" class="search_link {if $show.guilds == 'block'}nice_active{/if} nice_button">{lang('guilds', 'armory')} ({count($guilds)})</a>
	<a href="javascript:void(0)" onClick="Search.showTab(3, this)" class="search_link {if $show.items == 'block'}nice_active{/if} nice_button">{lang('items', 'armory')} ({count($items)})</a>
</div>

<div class="ucp_divider"></div>

<div id="search_tab_1" class="search_tab" style="display:{$show.characters}">
	{if count($characters) > 0}
		{foreach from=$characters item=character}
			<div class="search_result_realm_{$character.realm} search_result_character">
				<a href="{$url}character/{$character.realm}/{$character.guid}"><img width="54" height="54" src="{$url}application/images/avatars/{$character.avatar}.gif" class="avatar"/></a>
				<a class="color-c{$character.class} name" href="{$url}character/{$character.realm}/{$character.guid}">{$character.name}</a>
				<span>
					<b>{$character.level}</b> {$character.raceName} {$character.className}<br />
					{$character.realmName}
				</span>
			</div>
		{/foreach}
		<div class="clear"></div>
	{else}
		<center>{lang("no_characters_found", "armory")}</center>
	{/if}
</div>

<div id="search_tab_2" class="search_tab" style="display:{$show.guilds};">
	{if count($guilds) > 0}
		<table class="nice_table" cellspacing="0" >
			<tr>
				<td>{lang("name", "armory")}</td>
				<td align="center">{lang("members", "armory")}</td>
				<td>{lang("owner", "armory")}</td>
				<td>{lang("realm", "armory")}</td>
			</tr>

			{foreach from=$guilds item=guild}
				<tr class="search_result_realm_{$guild.realm} search_result_item">
					<td><a href="{$url}guild/{$guild.realm}/{$guild.id}" data-tip="View guild page">{$guild.name}</a></td>
					<td align="center">{$guild.members}</td>
					<td>
						<a href="{$url}character/{$guild.realm}/{$guild.ownerGuid}" data-tip="{lang('view_character_profile', 'armory')}">{$guild.ownerName}</a>
					</td>
					<td>{$guild.realmName}</td>
				</tr>
			{/foreach}
		</table>
	{else}
		<center>{lang("no_guilds_found", "armory")}</center>
	{/if}
</div>

<div id="search_tab_3" class="search_tab" style="display:{$show.items};">
	{if count($items) > 0}
		<table class="nice_table" cellspacing="0">
			<tr>
				<td width="30%">{lang("name", "armory")}</td>
				<td align="center" width="15%">{lang("level", "armory")}</td>
				<td align="center" width="15%">{lang("required", "armory")}</td>
				<td width="20%">{lang("type", "armory")}</td>
				<td width="20%">{lang("realm", "armory")}</td>
			</tr>

			{foreach from=$items item=item}
				<tr class="search_result_realm_{$item.realm} search_result_item">
					<td style="font-size:12px; !important">
						{$item.icon}
						&nbsp;
						<a href="{$url}item/{$item.realm}/{$item.id}" class="q{$item.quality}" data-realm="{$item.realm}" rel="item={$item.id}">
							{if strlen($item.name) < 22}
								{$item.name}
							{else}
								{substr($item.name,0,20)}...
							{/if}
						</a>
					</td>
					<td align="center" style="font-size:12px; !important">{$item.level}</td>
					<td align="center" style="font-size:12px; !important">{$item.required}</td>
					<td style="font-size:12px; !important">{$item.type}</td>
					<td style="font-size:12px; !important">{$item.realmName}</td>
				</tr>
			{/foreach}
		</table>
	{else}
		<center>{lang("no_items_found", "armory")}</center>
	{/if}
</div>
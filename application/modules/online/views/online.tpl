<section id="online_page">
	{foreach from=$realms item=realm}
		{if $realm->isOnline()}
		<a class="online_realm_button" href="javascript:void(0)" onClick="$('#online_realm_{$realm->getId()}').fadeToggle(400)">{$realm->getName()} ({$realm->getOnline()})</a>
		<section class="online_realm" id="online_realm_{$realm->getId()}" {if count($realms) == 1}style="display:block;"{/if}>
			{if $realm->getOnline() > 0}
			<table class="nice_table" cellspacing="0" cellpadding="0">
				<tr>
					<td width="15%"><a href="javascript:void(0)" onClick="Sort.name({$realm->getId()})">{lang("character", "online")}</a></td>
					<td width="15%" align="center"><a href="javascript:void(0)" onClick="Sort.level({$realm->getId()})">{lang("level", "online")}</a></td>
					<td width="15%" align="center">{lang("race", "online")}</td>
					<td width="15%" align="center">{lang("class", "online")}</td>
					<td width="40%"><a href="javascript:void(0)" onClick="Sort.location({$realm->getId()})">{lang("location", "online")}</a></td>
				</tr>

				{foreach from=$realm->getCharacters()->getOnlinePlayers() item=character}
				<tr>
					<td width="15%"><a data-tip="{lang("view_profile", "online")}" href="{$url}character/{$realm->getId()}/{$character.guid}">{$character.name}</a></td>
					<td width="15%" align="center">{$character.level}</td>
					<td width="15%" align="center"><img src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif" /></td>
					<td width="15%" align="center"><img src="{$url}application/images/stats/{$character.class}.gif" /></td>
					<td width="40%">{$realmsObj->getZone($character.zone)}</td>
				</tr>
				{/foreach}
			</table>
			{else}
				<center style="margin-bottom:10px;">{lang("no_players", "online")}</center>
			{/if}
		</section>
		{else}
			<a class="online_realm_button">{$realm->getName()} ({lang("offline", "online")})</a>
		{/if}
	{/foreach}
</section>
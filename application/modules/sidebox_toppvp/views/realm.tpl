{if $characters}
	{foreach from=$characters key=key item=character}
		<div class="toppvp_character">
			<div style="float:right">{$character.totalKills} {lang("kills", "sidebox_toppvp")}</div>
			<b>{$key + 1}</b>
			{if $showRace}<img align="absbottom" src="{$url}application/images/stats/{$character.race}-{$character.gender}.gif" />{/if}
			{if $showClass}<img align="absbottom" src="{$url}application/images/stats/{$character.class}.gif" />{/if}
			&nbsp;&nbsp;<a data-tip="{lang("view_profile", "sidebox_toppvp")}" href="{$url}character/{$realm}/{$character.guid}">{$character.name}</a> 
		</div>
	{/foreach}
{else}
<br />{lang("no_stats", "sidebox_toppvp")}<br /><br />
{/if}
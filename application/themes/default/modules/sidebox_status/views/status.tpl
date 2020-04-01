{foreach from=$realms item=realm}
	<div class="realm">
		<div class="realm_online">
			{if $realm->isOnline()}
				{$realm->getOnline()} / {$realm->getCap()}
			{else}
				{lang("offline")}
			{/if}
		</div>
		{$realm->getName()}
		
		<div class="realm_bar">
			{if $realm->isOnline()}
				<div class="realm_bar_fill" style="width:{$realm->getPercentage()}%"></div>
			{/if}
		</div>
		<div class="realm_status_bg"></div>
	</div>
{/foreach}
<div id="realmlist">set realmlist {$realmlist}</div>
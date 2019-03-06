<div id="gm">
	<div id="top_tools">
		{if $hasConsole && hasPermission("kick")}
			<a href="javascript:void(0)" onClick="Gm.kick({$realmId})" class="nice_button">
			<img src="{$url}application/images/icons/door_out.png" align="absmiddle">
				{lang("kick", "gm")}
			</a>
		{/if}

		{if hasPermission("ban")}
			<a href="javascript:void(0)" onClick="Gm.ban()" class="nice_button">
				<img src="{$url}application/images/icons/cross.png" align="absmiddle">
				{lang("ban", "gm")}
			</a>
		{/if}
	</div>
	{if $tickets}
		{foreach from=$tickets item=ticket}
		<div class="gm_ticket">
			<div class="gm_ticket_info">
				<table class="nice_table" cellspacing="0" cellpadding="0">
					<tr>
						<td width="30%">{lang("ticket", "gm")}</td>
						<td width="25%">{lang("time", "gm")}</td>
						<td width="30%">{lang("message", "gm")}</td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<td>#{$ticket.ticketId} {lang("by", "gm")} <a href="{$url}character/{$realmId}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
						<td>{$ticket.ago}</td>
						<td>{$ticket.message_short}</td>
						<td style="text-align:right;">
							<a class="nice_button" onClick="Gm.view(this)" href="javascript:void(0)"><img src="{$url}application/images/icons/bullet_toggle_plus.png" align="absmiddle"> {lang("view", "gm")}</a>
						</td>
					</tr>
				</table>
			</div>

			<div class="gm_ticket_info_full">
				<table class="nice_table" cellspacing="0" cellpadding="0">
					<tr>
						<td width="30%">{lang("ticket", "gm")}</td>
						<td width="25%">{lang("time", "gm")}</td>
						<td>&nbsp;</td>
					</tr>

					<tr>
						<td>#{$ticket.ticketId} {lang("by", "gm")} <a href="{$url}character/{$realmId}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
						<td>{$ticket.ago}</td>
						<td style="text-align:right;">
							<a class="nice_button" onClick="Gm.hide(this)" href="javascript:void(0)"><img src="{$url}application/images/icons/bullet_toggle_minus.png" align="absmiddle"> {lang("hide", "gm")}</a>
						</td>
					</tr>
				</table>
				<div class="gm_ticket_text">{$ticket.message}</div>
			</div>

			<div class="gm_tools">
				{if hasPermission("answer")}
					<a href="javascript:void(0)" onClick="Gm.close({$realmId}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/accept.png" align="absmiddle"> {lang("close", "gm")}</a>
					<a href="javascript:void(0)" onClick="Gm.answer({$realmId}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/email.png" align="absmiddle"> {lang("answer", "gm")}</a>
				{/if}

				{if hasPermission("unstuck")}
					<a href="javascript:void(0)" onClick="Gm.unstuck({$realmId}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/wand.png" align="absmiddle"> {lang("unstuck", "gm")}</a>
				{/if}

				{if hasPermission("sendItem")}
					<a href="javascript:void(0)" onClick="Gm.sendItem({$realmId}, {$ticket.ticketId}, this)" class="nice_button"><img src="{$url}application/images/icons/lorry.png" align="absmiddle"> {lang("send_item", "gm")}</a>
				{/if}
			</div>
		</div>
		{/foreach}
	{else}
		<div style="padding:20px;">{lang("no_tickets", "gm")}</div>
	{/if}
</div>
<div id="pm_controls">
	<div id="pm_controls_right">
		{if hasPermission("compose")}
			<a href="{$url}messages/create" class="nice_button">{lang("compose_message", "messages")}</a>
		{/if}
		<a href="javascript:void(0)" onClick="Messages.clearInbox()" class="nice_button" id="pm_empty">{lang("empty_inbox", "messages")}</a>
	</div>
	
	<a href="javascript:void(0)" onClick="Messages.showTab('inbox', this)" class="nice_button {if !$is_sent}nice_active{/if}">{lang("inbox", "messages")} ({$inbox_count})</a>
	<a href="javascript:void(0)" onClick="Messages.showTab('sent', this)" class="nice_button {if $is_sent}nice_active{/if}">{lang("sent_messages", "messages")} ({$sent_count})</a>
</div>
<div class="ucp_divider"></div>

<div id="pm_inbox" class="pm_spot" {if $is_sent}style="display:none;"{/if}>
	{if $messages}
		<table class="nice_table" width="100%">
			<tr>
				<td width="18%">{lang("sender", "messages")}</td>
				<td>{lang("message_title", "messages")}</td>
				<td width="18%" align="center">{lang("date", "messages")}</td>
			</tr>
			{foreach from=$messages item=message}
				<tr>
					<td><a href="{$url}profile/{$message.sender_id}" data-tip="View profile">{$message.sender_name}</td>
					<td><a href="{$url}messages/read/{$message.id}" data-tip="Read message" {if $message.read == 0}class="pm_new"{/if}>{$message.title}</a></td>
					<td align="center">{date("Y-m-d", $message.time)}</td>
				</tr>
			{/foreach}
		</table>
		<div style="height:10px;"></div>
		{$pagination}
	{else}
		<div style="text-align:center;padding:10px;">{lang("no_messages", "messages")}.</div>
	{/if}
</div>

<div id="pm_sent" class="pm_spot" {if !$is_sent}style="display:none;"{/if}>
	{if $sent}
		<table class="nice_table" width="100%">
			<tr>
				<td width="18%">{lang("receiver", "messages")}</td>
				<td>{lang("message_title", "messages")}</td>
				<td width="18%" align="center">Date</td>
			</tr>
			{foreach from=$sent item=message}
				<tr>
					<td><a href="{$url}profile/{$message.user_id}" data-tip="View profile">{$message.receiver_name}</td>
					<td><a href="{$url}messages/read/{$message.id}" data-tip="Read message">{$message.title}</a></td>
					<td align="center">{date("Y-m-d", $message.time)}</td>
				</tr>
			{/foreach}
		</table>
		<div style="height:10px;"></div>
		{$sent_pagination}
	{else}
		<div style="text-align:center;padding:10px;">{lang("no_messages", "messages")}.</div>
	{/if}
</div>
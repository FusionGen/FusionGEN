{if !$messages}
	<center style="margin:10px;font-weight:bold;">Message not found</center>
{else}
	<div id="pm_read">
		{foreach from=$messages item=message}
			<div class="message_box" style="float:{if $message.sender_id == $me}right{else}left{/if}">
				<div class="message_box_date" style="float:{if $message.sender_id == $me}left{else}right{/if}">{date("Y/m/d", $message.time)}</div>
				<a href="{$url}profile/{$message.sender_id}" data-tip="View profile" style="float:{if $message.sender_id == $me}right{else}left{/if}"><img src="{$message.avatar}" height="44" width="44" style="{if $message.sender_id == $me}margin-right:0px;{/if}"/></a>
				<a class="message_box_author" href="{$url}profile/{$message.sender_id}" data-tip="View profile" style="text-align:{if $message.sender_id == $me}right{else}left{/if}">{$message.name}</a>
				{$message.message}
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		{/foreach}
			<div id="pm_spot">
				<div id="pm_spot_ajax"></div>
				<div id="pm_spot_message" class="message_box" style="float:right;display:none;">
					<div class="message_box_date" id="pm_date" style="float:left"></div>
					<a href="{$url}profile/{$me}" data-tip="View profile" style="float:right"><img src="{$myAvatar}" height="44" width="44" style="margin-right:0px;"/></a>
					<a class="message_box_author" href="{$url}profile/{$me}" data-tip="{lang("view_profile", "messages")}" style="text-align:right">{lang("you", "messages")}</a>
					<span id="pm_message"></span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			
		{if hasPermission("reply")}
			<div id="pm_form">
				{$editor}
				<div style="height:15px;"></div>
				<center>
					<form onSubmit="Read.reply({$him}); return false">
						<a class="nice_button" href="{$url}messages">&larr; {lang("inbox", "messages")}</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" value="{lang("send", "messages")}" />
					</form>
				</center>
			</div>
		{/if}
	</div>
{/if}
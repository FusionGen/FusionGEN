<table class="table table-hover mb-0">
	{foreach from=$logs item=log}
		<tr>
			<td width="15%"><b>{ucfirst($log.module)}</b></td>
			<td width="20%">{date("Y-m-d H:i:s", $log.time)}</td>
			<td width="15%">{$log.ip}</td>
			<td width="10%">
				{if $log.user_id == 0}
					Guest
				{else}
					<a data-toggle="tooltip" title="View profile" href="../profile/{$log.user_id}" target="_blank">{$CI->user->getUsername($log.user_id)}</a>
				{/if}
			</td>
			<td class="text-center" width="15%">
			{if $log.status == 'succeed'}
				<span class="text-success"><i class="fa-regular fa-circle-check fa-xl"></i></span>
			{else}
				<span class="text-danger"><i class="fa-regular fa-circle-xmark fa-xl"></i></span>
			{/if}
			</td>
			<td>
			{$log.message}
				{if $log.custom}
					<span class="text-nowrap"><br>
					{foreach $log.custom|json_decode as $key => $value}
						<b>{ucfirst($key)}</b>:
						{foreach $value as $subKey => $subValue}
							{if $subKey == 'old'}
								{$subValue} ->
							{elseif $subKey == 'new'}
								{$subValue}
							{else}
								{$subValue}
							{/if}
						{/foreach}<br>
					{/foreach}
					</span>
				{/if}
			</td>
		</tr>
	{/foreach}
</table>
<span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
	<!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
	<a id="button_log_count" class="btn btn-primary btn-sm" style="display:block" onClick="Logging.loadMore(); return false;">Show more ({$show_more})</a>
	<input type="hidden" id="js_load_more" value="{$show_more}">
</span>

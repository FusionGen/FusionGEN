<table class="table table-responsive-md table-hover mb-0">
{foreach from=$logs item=log}
    <tr>
        <td width="15%"><b>{ucfirst($log.module)}</b></td>
        <td width="30%">{$log.logType} <a data-toggle="tooltip" data-placement="bottom" title="{$log.logMessage}">(details)</a></td>
        <td width="15%" >
            {if $log.user == 0}
                Guest
                {else}
                <a data-toggle="tooltip" data-placement="bottom" title="View profile" href="../profile/{$log.user}" target="_blank">{$CI->user->getUsername($log.user)}</a>
            {/if}
        </td>
        <td width="15%" style="font-size:10px;">{$log.ip}</td>
        <td width="15%" style="font-size:10px;">{date("Y-m-d H:i", $log.time)}</td>
    </tr>
{/foreach}
</table>
<span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
	<!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
	<a id="button_log_count" class="btn btn-primary btn-sm" style="display:block" onClick="Logging.loadMore(); return false;">Show more ({$show_more})</a>
	<input type="hidden" id="js_load_more" value="{$show_more}"/>
</span>
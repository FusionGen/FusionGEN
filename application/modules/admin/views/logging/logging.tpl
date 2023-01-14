<div class="card" id="main_link">
	<div class="card-header">Logs</div>
	<div class="card-body">
	<form class="form-inline d-flex md-form form-sm mt-0" onSubmit="Logging.search(); return false">
		<select id="module" name="module" class="form-control" style="margin-right:15px;">
			<option selected="selected" value="">-- All modules --</option>
			{foreach from=$modules item=module key=key}
				<option value="{$key}">{ucfirst($key)}</option>
			{/foreach}
		</select>
		<input class="form-control form-control-sm ml-3 w-75" type="text" name="search" id="search" placeholder="Search by username, IP address or user ID" style="width:90%;margin-right:5px;">
		<button class="btn btn-primary btn-sm" type="submit">Search</button>
	</form>

	<span id="log_list">
        {if $logs}
		<table class="table table-responsive-md table-hover mb-0">
            {foreach from=$logs item=log}
                        <tr>
                            <td width="15%"><b>{ucfirst($log.module)}</b></td>
                            <td width="30%">{$log.logType} <a data-toggle="tooltip" title="{$log.logMessage}">(details)</a></td>
                            <td width="15%" >
                                {if $log.user == 0}
                                    Guest
                                {else}
                                    <a data-toggle="tooltip" title="View profile" href="../profile/{$log.user}" target="_blank">{$CI->user->getUsername($log.user)}</a>
                                {/if}
                                </td>
                            <td width="15%">{$log.ip}</td>
                            <td width="15%">{date("Y-m-d H:i", $log.time)}</td>
                        </tr>
                    
            {/foreach}
		</table>
            <span id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
                <!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
                <a id="button_log_count" class="btn btn-primary btn-sm" style="display:block" onClick="Logging.loadMore();">Show more ({$show_more})</a>
                <input type="hidden" id="js_load_more" value="{$show_more}"/>
            </span>
        {/if}
	</span>
	</div>
</div>
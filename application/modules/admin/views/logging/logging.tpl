<section class="box big" id="main_link">
	<h2>
		Logs
	</h2>

	<!-- Note to whoever continues this: create javascript Logging object -->
	<form style="margin-top:0px;" onSubmit="Logging.search(); return false">
		<select id="module" name="module" style="margin-top:15px;">
			<option selected="selected" value="">-- All modules --</option>
			{foreach from=$modules item=module key=key}
				<option value="{$key}">{ucfirst($key)}</option>
			{/foreach}
		</select>
		<input type="text" name="search" id="search" placeholder="Search by username, IP address or user ID" style="width:90%;margin-right:5px;">
		<input type="submit" value="Search" style="display:inline;padding:8px;margin-top:0px;">
	</form>

	<ul id="log_list">
        {if $logs}
            {foreach from=$logs item=log}
                <li>
                    <table width="100%">
                        <tr>
                            <td width="15%"><b>{ucfirst($log.module)}</b></td>
                            <td width="30%">{$log.logType} <a data-tip="{$log.logMessage}">(details)</a></td>
                            <td width="15%" >
                                {if $log.user == 0}
                                    Guest
                                {else}
                                    <a data-tip="View profile" href="../profile/{$log.user}" target="_blank">{$CI->user->getUsername($log.user)}</a>
                                {/if}
                                </td>
                            <td width="15%" style="font-size:10px;">{$log.ip}</td>
                            <td width="15%" style="font-size:10px;">{date("Y-m-d H:i", $log.time)}</td>
                        </tr>
                    </table>
                </li>
            {/foreach}
            <li id="show_more_count" {if $show_more <= 0}style="display:none;"{/if}>
                <!-- Instead of pagination, just use a "show more" button that will show next X logs every time you press it -->
                <a id="button_log_count" class="nice_button" style="display:block" onClick="Logging.loadMore(); return false;">Show more ({$show_more})</a>
                <input type="hidden" id="js_load_more" value="{$show_more}"/>
            </li>
        {/if}
	</ul>

</section>
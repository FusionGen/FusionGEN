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
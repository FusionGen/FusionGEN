{if $type == "paypal"}
	{foreach from=$results item=paypal_log}
		<tr>
			<th scope="row">{date("Y/m/d H:i:s", $paypal_log.create_time)}</th>
			<td>
				<a href="{$url}admin/accounts/get/{$paypal_log.user_id}" target="_blank">
					{$paypal_log.nickname}
				</a>
			</td>
			<td>{$paypal_log.total} {$paypal_log.currency}</td>
			<td>{$paypal_log.payment_id}</td>
			<td>{if $paypal_log.status}{else}No {/if}Validated</td>
			<td>
				{if !$paypal_log.status}
					<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Donate.give({$paypal_log.id}, this)">Give DP</a>
				{/if}
			</td>
		</tr>
	{/foreach}
{/if}
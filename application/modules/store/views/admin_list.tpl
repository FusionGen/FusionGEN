{foreach from=$results item=order_log}
	<li>
		<table width="100%">
			<tr>
				<td width="20%">{date("Y/m/d", $order_log.timestamp)}</td>
				<td width="16%">
					<a href="{$url}profile/{$order_log.user_id}" target="_blank">
						{$order_log.username}
					</a>
				</td>

				<td width="35%">
					{if $order_log.vp_cost}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" style="margin:0px;opacity:1;" /> <b>{$order_log.vp_cost} VP</b>&nbsp;&nbsp;&nbsp;{/if}
					{if $order_log.dp_cost}<img src="{$url}application/images/icons/coins.png" align="absmiddle"  style="margin:0px;opacity:1;"/> <b>{$order_log.dp_cost} DP</b>{/if}
				</td>

				<td>
					<a data-tip="{foreach from=$order_log.json item=item}{$item.itemName} to {$item.characterName}<br />{/foreach}">{count($order_log.json)} items</a>
				</td>

				{if $order_log.completed == '0' && hasPermission("canRefundOrders")}
					<td style="text-align:right;">
						<a class="nice_button" href="javascript:void(0)" onClick="Orders.refund({$order_log.id}, this)">Refund</a>
					</td>
				{/if}
			</tr>
		</table>
	</li>
{/foreach}
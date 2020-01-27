<section class="box big">
	<h2>
		Failed orders in the past week
	</h2>

	<span>
		Orders that show up here have failed because of a system error. If the error didn't occur immediately some items might have been delivered. You should manually investigate if the user should be refunded.
	</span>

	<ul id="order_list_failed">
		{if $failed}
			{foreach from=$failed item=failed_log}
				<li>
					<table width="100%">
						<tr>
							<td width="20%">{date("Y/m/d", $failed_log.timestamp)}</td>
							<td width="16%">
								<a href="{$url}admin/accounts/get/{$failed_log.user_id}" target="_blank">
									{$failed_log.username}
								</a>
							</td>
							
							<td width="35%">
								{if $failed_log.vp_cost}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" style="margin:0px;opacity:1;" /> <b>{$failed_log.vp_cost} VP</b>&nbsp;&nbsp;&nbsp;{/if}
								{if $failed_log.dp_cost}<img src="{$url}application/images/icons/coins.png" align="absmiddle"  style="margin:0px;opacity:1;"/> <b>{$failed_log.dp_cost} DP</b>{/if}
							</td>

							<td>
								<a data-tip="{foreach from=$failed_log.json item=item}{$item.itemName} to {$item.characterName}<br />{/foreach}">{count($failed_log.json)} items</a>
							</td>
							
							{if hasPermission("canRefundOrders")}
								<td style="text-align:right;">
									<a class="nice_button" href="javascript:void(0)" onClick="Orders.refund({$failed_log.id}, this)">Refund</a>
								</td>
							{/if}
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>

<section class="box big">
	<h2>
		Last 10 successful orders
	</h2>

	<form style="margin-top:0px;" onSubmit="Orders.search('successful'); return false">
		<input type="text" name="search_successful" id="search_successful" placeholder="Search by username" style="width:90%;margin-right:5px;"/>
		<input type="submit" value="Search" style="display:inline;padding:8px;" />
	</form>

	<ul id="order_list_successful">
		{if $completed}
			{foreach from=$completed item=completed_log}
				<li>
					<table width="100%">
						<tr>
							<td width="20%">{date("Y/m/d", $completed_log.timestamp)}</td>
							<td width="16%">
								<a href="{$url}admin/accounts/get/{$completed_log.user_id}" target="_blank">
									{$completed_log.username}
								</a>
							</td>
							
							<td width="35%">
								{if $completed_log.vp_cost}<img src="{$url}application/images/icons/lightning.png" align="absmiddle" style="margin:0px;opacity:1;" /> <b>{$completed_log.vp_cost} VP</b>&nbsp;&nbsp;&nbsp;{/if}
								{if $completed_log.dp_cost}<img src="{$url}application/images/icons/coins.png" align="absmiddle"  style="margin:0px;opacity:1;"/> <b>{$completed_log.dp_cost} DP</b>{/if}
							</td>

							<td>
								<a data-tip="{foreach from=$completed_log.json item=item}{$item.itemName} to {$item.characterName}<br />{/foreach}">{count($completed_log.json)} items</a>
							</td>
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>
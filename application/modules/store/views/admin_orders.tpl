<div class="card">
	<div class="card-header">
		Failed orders in the past week
	</div>
	<div class="card-body">
	<span>
		Orders that show up here have failed because of a system error. If the error didn't occur immediately some items might have been delivered. You should manually investigate if the user should be refunded.
	</span>

		{if $failed}
		<table class="table table-responsive-md table-hover">
			{foreach from=$failed item=failed_log}
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
							<a data-bs-toggle="tooltip" data-placement="top" data-html="true" title="{foreach from=$failed_log.json item=item}{$item.itemName} to {$item.characterName}<br>{/foreach}">{count($failed_log.json)} items</a>
						</td>
						
						{if hasPermission("canRefundOrders")}
							<td style="text-align:right;">
								<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Orders.refund({$failed_log.id}, this)">Refund</a>
							</td>
						{/if}
					</tr>
			{/foreach}
			</table>
		{/if}
	</div>
</div>

<div class="card">
	<div class="card-header">
		Last 10 successful orders
	</div>
	<div class="card-body">
	<form class="input-group mb-3" onSubmit="Orders.search('successful'); return false">
		<input class="form-control" type="text" name="search_successful" id="search_successful" placeholder="Search by username" style="width:90%;margin-right:5px;"/>

		<button type="submit" class="btn btn-primary">Search</button>
	</form>

	<span id="order_list_successful">
		{if $completed}
			{foreach from=$completed item=completed_log}
				<table class="table table-responsive-md table-hover">
					<tbody style="border-top:none">
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
							<a data-toggle="tooltip" data-placement="top" data-html="true" title="{foreach from=$completed_log.json item=item}{$item.itemName} to {$item.characterName}<br />{/foreach}">{count($completed_log.json)} items</a>
						</td>
					</tbody>
					</tr>
				</table>
			{/foreach}
		{/if}
	</span>
	</div>
</div>
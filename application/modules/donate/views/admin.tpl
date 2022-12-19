{if $paypal_enabled}
	<div class="card" id="donate_articles">
		<header class="card-header">
			Last 10 PayPal donations
		</header>

		<div class="card-body">
		<form style="margin-top:0px;" onSubmit="Donate.search('paypal'); return false">
			<div class="input-group mb-3">
				<input class="form-control" type="text" name="search_paypal" id="search_paypal" placeholder="Search by username or Payment ID" />
				<input class="btn btn-primary" type="submit" value="Search" />
			</div>
		</form>
	
		{if $paypal_logs}
			<table class="table table-responsive-md table-hover">
				<thead>
					<tr>
						<th scope="col">Date</th>
						<th scope="col">Username</th>
						<th scope="col">Price</th>
						<th scope="col">Payment ID</th>
						<th scope="col">Valide</th>
						<th scope="col">Actions</th>
					</tr>
				</thead>
				<tbody id="donate_list_paypal">
					{foreach from=$paypal_logs item=paypal_log}
						<tr id="paypal_id_{$paypal_log.id}">
							<th scope="row">{date("Y/m/d H:i:s", $paypal_log.create_time)}</th>
							<td>
								<a href="{$url}admin/accounts/get/{$paypal_log.user_id}" target="_blank">
									{$paypal_log.nickname}
								</a>
							</td>
							<td>{$paypal_log.total} {$paypal_log.currency}</td>
							<td>{$paypal_log.payment_id}</td>
							<td class="paypal_valide">{if $paypal_log.status}{else}No {/if}Validated</td>
							<td>
								{if !$paypal_log.status}
									<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Donate.give({$paypal_log.id}, this)">Give DP</a>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		{else}
			No Logs...
		{/if}
	</div>
	</div>
{/if}
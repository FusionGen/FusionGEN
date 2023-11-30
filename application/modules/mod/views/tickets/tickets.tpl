<div class="card mb-3">
	<header class="card-header">
		{$realmName}

		{if $hasConsole}
			<a href="javascript:void(0)" onClick="Mod.kick({$realmId})" class="btn btn-primary btn-sm pull-right mx-1">
			<img src="{$url}application/images/icons/door_out.png" align="absmiddle">
				Kick
			</a>
		{/if}
	</header>
	<div class="card-body">
		<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>From</th>
					<th>Time</th>
					<th>Message</th>
					<th style="text-align:center;">Action</th>
				</tr>
			</thead>
			<tbody>
			{if $tickets}
				{foreach from=$tickets item=ticket}
					<tr>
						<td>#{$ticket.ticketId}</td>
						<td><a href="{$url}character/{$realmId}/{$ticket.guid}" target="_blank">{$ticket.name}</a></td>
						<td>{$ticket.ago}</td>
						<td>{$ticket.message_short}</td>
						<td style="text-align:center;">
							<a class="btn btn-primary btn-sm" href="{$url}mod/tickets/view/{$realmId}/{$ticket.ticketId}"> View</a>
						</td>
					</tr>
				{/foreach}
			{/if}
			</tbody>
		</table>
	</div>
</div>

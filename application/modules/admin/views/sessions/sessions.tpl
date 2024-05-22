<div class="col-12">
	<div class="card">
		<div class="card-header">
		Users in the past 30 minutes (<strong>{if $sessions}{count($sessions)}{else}0{/if}</strong>)
		<button class="btn btn-primary btn-sm pull-right" onClick="Session.delete()">Clear sessions</button>
		</div>
		<div class="card-body table-responsive">
			<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Time</th>
					<th scope="col">Name</th>
					<th scope="col">IP</th>
					<th scope="col">Browser</th>
					<th scope="col">OS</th>
				</tr>
			</thead>
			<tbody>
				{if $sessions}
					{foreach from=$sessions item=visitor}
						<tr>
							<td width="15%">
								{$visitor.date}
							</td>
							<td width="20%">
								{if isset($visitor.nickname)}
									<a href="{$url}profile/{$visitor.uid}" target="_blank">{$visitor.nickname}</a>
								{else}
									Guest
								{/if}
							</td>
							<td>
								{$visitor.ip_address}
							</td>
							<td width="20%">
								<img src="{$url}application/images/browsers/{$visitor.browser}.png" style="margin-top:-2px;"> {ucfirst($visitor.browser)}
							</td>
							<td width="20%">
								<img src="{$url}application/images/platforms/{$visitor.os}.png" style="margin-top:-2px;"> {ucfirst($visitor.os)}
							</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
			</table>
		</div>
    </div>
</div>

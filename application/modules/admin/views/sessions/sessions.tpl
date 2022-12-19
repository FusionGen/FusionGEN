<div class="col-12">
	<div class="card">
		<div class="card-header">Users in the past 30 minutes (<strong>{count($sessions)}</strong>)</div>
		<div class="card-body">
			<table class="table table-responsive-md table-hover">
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
									<a href="{$smarty.const.pageURL}profile/{$visitor.id}" target="_blank">{$visitor.nickname}</a>
								{else}
									Guest
								{/if}
							</td>
							<td>
								{$visitor.ip_address}
							</td>
							<td width="20%">
								<img src="{$smarty.const.pageURL}application/images/browsers/{$visitor.browser}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.browser)}
							</td>
							<td width="20%">
								<img src="{$smarty.const.pageURL}application/images/platforms/{$visitor.os}.png" style="opacity:1;position:absolute;margin-top:2px;"/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ucfirst($visitor.os)}
							</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
			</table>
		</div>
    </div>
</div>
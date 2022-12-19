<div class="card">
	<div class="card-header">
		Teleport locations (<div style="display:inline;" id="teleport_count">{if !$teleport_locations}0{else}{count($teleport_locations)}{/if}</div>){if hasPermission("canAdd")}<a class="btn btn-primary btn-sm pull-right" href="{$url}teleport/admin/new">Create teleport location</a>{/if}
	</div>

	<div class="card-body">
		{if $teleport_locations}
		<table class="table table-responsive-md table-hover">
		<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Realm</th>
					<th>Cost</th>
					<th style="text-align: center;">Action</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$teleport_locations item=teleport_location}
				<tr>
					<td><b>{$teleport_location.name}</b></td>
					<td>{$teleport_location.description}</td>
					<td>{$teleport_location.realmName}</td>
					<td>
						{if $teleport_location.vpCost}
							<img src="{$url}application/images/icons/lightning.png" style="opacity:1;" /> {$teleport_location.vpCost} VP
						{elseif $teleport_location.dpCost}
							<img src="{$url}application/images/icons/coins.png" style="opacity:1;"/>
							{$teleport_location.dpCost} DP
						{elseif $teleport_location.goldCost}
						<img src="{$url}application/images/icons/coins.png" style="opacity:1;"/>
							{$teleport_location.goldCost} Gold
						{else}
							Free
						{/if}
					</td>
					<td style="text-align:center;">
						{if hasPermission("canEdit")}
							<a class="btn btn-primary btn-sm" href="{$url}teleport/admin/edit/{$teleport_location.id}">Edit</a>
						{/if}
						{if hasPermission("canRemove")}
							<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Teleport.remove({$teleport_location.id}, this)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
			</table>
		{/if}
	</div>
</div>
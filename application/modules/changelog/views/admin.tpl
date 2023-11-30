<div class="card">
	<div class="card-header">
		Changes (<div style="display:inline;" id="changelog_count">{if !$changes}0{else}{count($changes)}{/if}</div>)
	</div>
	<div class="card-body">
	{if $categories}

	{foreach from=$categories item=category}
	<div class="card-header mb-3">
		<table class="table table-responsive-md" id="headline_{$category.id}">
		<tbody style="border-top:none;">
			<tr>
				<td><b>{$category.typeName}</b></td>

				<td class="pull-right">
					{if hasPermission("canEditCategory")}
						<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Changelog.renameCategory({$category.id}, this)">Edit</a>
					{/if}

					{if hasPermission("canRemoveCategory")}
						<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Changelog.removeCategory({$category.id}, this)">Delete</a>
					{/if}
				</td>
			</tr>
		</tbody>
		</table>

		{foreach from=$changes item=change}
			{if $category.id == $change.type}
			<div class="card-body">
				<table class="table table-responsive-md">
					<thead>
						<tr>
							<th>Change</th>
							<th>User</th>
							<th>Date</th>
							<th style="text-align: center;">Action</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>{$change.changelog}</td>
						<td>{$change.author}</td>
						<td>{date('Y/m/d', $change.time)}</td>

						<td style="text-align:center;">
							{if hasPermission("canEditChange")}
								<a class="btn btn-primary btn-sm" href="{$url}changelog/admin/edit/{$change.change_id}">Edit</a>
							{/if}

							{if hasPermission("canRemoveChange")}
								<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Changelog.remove({$change.change_id}, this)">Delete</a>
							{/if}
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			{/if}
		{/foreach}
	</div>
	{/foreach}
	{/if}
	</div>
</div>

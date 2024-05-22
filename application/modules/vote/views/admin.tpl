<div class="card">
	<div class="card-header">
		Topsites (<div class="d-inline" id="topsites_count">{if !$topsites}0{else}{count($topsites)}{/if}</div>){if hasPermission("canCreate")}<a class="btn btn-primary btn-sm pull-right" href="{$url}vote/admin/new">Create topsite</a>{/if}
	</div>

	<div class="card-body table-responsive">
		{if $topsites}
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Interval</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$topsites item=vote_site}
				<tr>
					<td>{if $vote_site.vote_image}<img src="{$vote_site.vote_image}">{else}{$vote_site.vote_sitename}{/if}</td>
					<td class="align-middle">{$vote_site.points_per_vote} voting point{if $vote_site.points_per_vote > 1}s{/if}</td>
					<td class="align-middle">{$vote_site.hour_interval} hours</td>
					<td class="align-middle text-center">
						{if hasPermission("canEdit")}
						<a class="btn btn-primary btn-sm" href="{$url}vote/admin/edit/{$vote_site.id}">Edit</a>
						{/if}

						{if hasPermission("canDelete")}
						<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Topsites.remove({$vote_site.id}, this)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
		</table>
		{/if}
	</div>
</div>

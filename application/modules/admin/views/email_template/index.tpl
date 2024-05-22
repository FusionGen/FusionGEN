<section class="card">
	<header class="card-header">Email templates</header>
	<div class="card-body table-responsive">
	{if $templates}
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$templates item=template}
			<tr>
				<td class="fw-bold">{$template.id}</td>
				<td>{$template.template_name}</td>
				<td class="text-center">
					<a class="btn btn-primary btn-sm" href="{$url}admin/email_template/edit/{$template.id}">Edit</a>
				</td>
			</tr>
		{/foreach}
		</tbody>
		</table>
	{/if}
	</div>
</section>

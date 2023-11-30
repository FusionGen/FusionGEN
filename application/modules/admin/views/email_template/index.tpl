<section class="card">
	<header class="card-header">Email templates</header>
	<div class="card-body">
	{if $templates}
	<table class="table table-responsive-md table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th style="text-align: center;">Action</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$templates item=template}
			<tr>
				<td><b>{$template.id}</b></td>
				<td>{$template.template_name}</td>
				<td style="text-align:center;">
					<a class="btn btn-primary btn-sm" href="{$url}admin/email_template/edit/{$template.id}">Edit</a>
				</td>
			</tr>
		{/foreach}
		</tbody>
		</table>
	{/if}
	</div>
</section>

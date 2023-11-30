<section class="card" id="main_link">
	<header class="card-header">
		Languages (<div style="display:inline;" id="logs_count">{if !$languages}0{else}{count($languages)}{/if}</div>)
	</header>

<div class="card-body">
<table class="table table-responsive-md table-hover mb-0" id="log_list">
	<thead>
		<tr>
			<th>Language</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	{if $languages}
		{foreach from=$languages item=language key=flag}
				<tr>
				<td><img src="{$url}application/images/flags/{$flag}.png" alt="{$flag}"> {ucfirst($language)}</td>

				<td>{if $language == $default}
						<div style="color:green" class="pull-right">Default language</div>
					{elseif hasPermission("changeDefaultLanguage")}
						<a class="btn btn-primary btn-sm pull-right" href="javascript:void(0)" onClick="Languages.set('{$language}')">Set as default</a>
					{/if}
				</td>
				</tr>
		{/foreach}
	{/if}
	</tbody>
</table>
</div>
</div>

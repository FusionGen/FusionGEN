{TinyMCE()}
<div class="card">
<header class="card-header">Articles (<div style="display:inline;" id="article_count">{if !$news}0{else}{count($news)}{/if}</div>)</h3>
	{if hasPermission("canAddArticle")}
	<a class="btn btn-primary btn-sm pull-right" href="{$url}news/admin/new">Create article</a>
	{/if}
</header>
<div class="card-body">
<table class="table">
	<thead>
		<tr>
			<th scope="col" class="name">Headline</th>
			<th scope="col" class="name">From</th>
			<th scope="col" class="date">Date</th>
			<th scope="col" class="comments">Comments</th>
			<th scope="col" style="text-align:center;width:9%;" class="actions">Actions</th>
		</tr>
	</thead>
	<tbody>
		{if $news}
		{foreach from=$news item=article}
			<tr>
				{$defaultLang='headline_'|cat:$lang}  
				<td width="25%"><b>{$article.$defaultLang}</b></td>
				<td width="15%">{$article.nickname}</td>
				<td width="20%">{date("Y/m/d", $article.timestamp)}</td>
				<td width="10%">{if $article.comments != -1}{$article.comments}{else}Off{/if}</td>
				<td width="10%" style="text-align:right;">
					{if $article.id > 0}
						{if hasPermission("canEditArticle")}
						<a href="{$url}news/admin/edit/{$article.id}"><button type="button" class="btn btn-primary btn-sm">Edit</button></a>&nbsp;
						{/if}
						{if hasPermission("canRemoveArticle")}
						<a href="javascript:void(0)" onClick="News.remove({$article.id}, this)"><button type="button" class="btn btn-primary btn-sm">Delete</button></a>
						{/if}
					{/if}
				</td>
			</tr>
		{/foreach}
		{/if}
	</tbody>
</table>
</div>
</div>

{foreach from=$articles item=article}
	<article>
		<a href="{$url}news/view/{$article.id}" class="headline">{langColumn($article.headline)}</a>
		<div class="content">
			{if $article.avatar}
				<div class="avatar">
					<img src="{$article.avatar}" alt="avatar" height="120" width="120">
				</div>
			{/if}

			{langColumn($article.content)}
			<div class="clear"></div>
		</div>

		<div class="news_bottom">

			{if $article.comments != -1}
				<a {$article.link} class="news_comments" {$article.comments_button_id}>
					{lang("comments", "news")} ({$article.comments})
				</a>
			{/if}

			{lang("posted_by", "news")} <b><a href="{$url}profile/{$article.author_id}" data-tip="{lang("view_profile", "news")}">{$article.author}</a></b> {lang("on", "news")} <b>{$article.date}</b>

			{if $article.tags}
				{foreach from=$article.tags item=tag}
					<a href="{$url}/news/{$tag.name}">{$tag.name}</a>
				{/foreach}
			{/if}
		</div>

		<div class="comments" {$article.comments_id}></div>
	</article>
{/foreach}
{$pagination}
{foreach from=$articles item=article}
	<article>
		<a href="{$url}news/view/{$article.id}" class="top">{$article.headline}</a>
		<section class="body">
			{if $article.avatar}
				<div class="avatar">
					<img src="{$article.avatar}" alt="avatar" height="120" width="120">
				</div>
			{/if}
			
			{$article.content}
			
			<div class="clear"></div>
			
			<div class="news_bottom">

				{if $article.comments != -1}
					<a {$article.link} class="comments_button" {$article.comments_button_id}>
						{lang("comments", "news")} ({$article.comments})
					</a>
				{/if}

				{lang("posted_by", "news")} <a href="{$url}profile/{$article.author_id}" data-tip="{lang("view_profile", "news")}">{$article.author}</a> {lang("on", "news")} {$article.date}

				{if $article.tags}
					{foreach from=$article.tags item=tag}
						<a href="{$url}/news/{$tag.name}">{$tag.name}</a>
					{/foreach}
				{/if}
			</div>

			<div class="comments" {$article.comments_id}></div>
		</section>
	</article>

{/foreach}
{$pagination}
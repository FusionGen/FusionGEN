{foreach from=$articles item=article}
	<article id="article-{$article.id}" class="news article box expandable {if $article != reset($articles)}collapsed{/if}">
		<h2 class="head">
			<a href="{$url}news/view/{$article.id}">{langColumn($article.headline)}</a>
		</h2>
		<div class="body" {if $article != reset($articles)}style="display:none"{/if}>
			{if $article.avatar}
				<div class="avatar">
					<img src="{$article.avatar}" alt="avatar" height="80" width="80">
				</div>
			{/if}
			
			{langColumn($article.content)}
			
			<div class="foot">
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
		</div>
	</article>
{/foreach}

{$pagination}

<script type="text/javascript">
	$('.expandable > .head').on('click', function() {
		var parent = $(this).parent();
		parent.toggleClass('collapsed').find('> .body').slideToggle();
		setCookie(parent.prop('id'), parent.hasClass('collapsed') ? 1 : 0, 7);
	});
	
	$('.closeable > .close-btn').on('click', function() {
		var parent = $(this).parent();
		parent.toggleClass('closed').fadeToggle(0);
		setCookie(parent.prop('id'), parent.hasClass('closed') ? 1 : 0, 7);
	});
	
	$(function() {
		$('.expandable').each(function() {
			var element = $(this),
				collapsed = element.hasClass('collapsed'),
				cookie = getCookie(element.prop('id')) == 1;
			if((cookie && !collapsed) || (!cookie && collapsed))
				element.find('> .head').trigger('click');
		});
		
		$('.closeable').each(function() {
			var element = $(this),
				closed = element.hasClass('closed'),
				cookie = getCookie(element.prop('id')) == 1;
			if(!element.find('> .close-btn').length)
				element.prepend('<a href="javascript:void(0)" class="close-btn"></a>');
			if((cookie && !closed) || (!cookie && closed))
				element.find('> .close-btn').trigger('click');
		});
	});
</script>
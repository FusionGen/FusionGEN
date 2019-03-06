{foreach from=$comments item=comment}
	<div class="{if $comment.is_gm}staff_comment{/if} comment">
		<div class="comment_date">{date("Y/m/d", $comment.timestamp)} {if hasPermission("canRemoveComment")}<a href="javascript:void(0)" onClick="Ajax.remove(this, {$comment.id})"><img src="{$url}application/images/icons/delete.png" align="absmiddle" style="border:none !important;margin-right:0px !important;box-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;float:none !important;"/></a>{/if}</div>
		<a href="{$comment.profile}" data-tip="{lang("view_profile", "news")}><img src="{$comment.avatar}" height="44" width="44"/></a>
		<a class="comment_author" href="{$comment.profile}" data-tip="{lang("view_profile", "news")}">{if $comment.is_gm}<img src="{$url}application/images/icons/icon_blizzard.gif" align="absmiddle" style="border:none !important;margin-right:0px !important;box-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;"/>&nbsp;{/if} {$comment.author}</a>
		{word_wrap($comment.content, 30)}
		<div class="clear"></div>
	</div>
{/foreach}
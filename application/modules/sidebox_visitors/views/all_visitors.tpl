{if $visitors}
	{foreach from=$visitors key=user_id item=nickname}
		<a href="{$url}profile/{$user_id}">{$nickname}</a>,
	{/foreach}
{/if}

{if $guests}
	{$guests}

	{if $guests == 1}
		{lang("guest", "sidebox_visitors")}
	{else}
		{lang("guests", "sidebox_visitors")}
	{/if}.
{/if}
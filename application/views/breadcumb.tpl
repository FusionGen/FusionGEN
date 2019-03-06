{foreach from=$links item=item key=link}
	<span style='cursor:pointer;' onClick='window.location="{$url}{$link}"'>{$item}</span>
	{if $item != end($links)} &rarr; {/if}
{/foreach}
{if $characters > 0}
<div class="ucp_divider"></div>
<section id="ucp_characters">
	{foreach from=$realms item=realm}
		{if $realm->getCharacterCount($id) > 0}
			<h1>{$realm->getName()}</h1>
			{foreach from=$realm->getCharacters()->getCharactersByAccount($id) item=character}
				<a href="{$url}character/{$realm->getId()}/{$character.name}" data-tip="<img src='{$url}application/images/stats/{$character.class}.gif' align='absbottom'/>&nbsp;&nbsp;{$character.name}">
					<img src="{$url}application/images/avatars/{$realmsObj->formatAvatarPath($character)}.gif" />
				</a>
			{/foreach}
		{/if}
	{/foreach}
	<div class="clear"></div>
</section>
{/if}
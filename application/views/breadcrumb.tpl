<nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
  <ol class="breadcrumb">
	{foreach from=$links item=item key=link}
		<li class="breadcrumb-item {if $item == end($links)} active {/if}">
			<a {if !$item}class="d-none"{/if} href="{$url}{$link}">{$item}</a>
		</li>

		{if $item != end($links)}<li class="breadcrumb-item">➜</li>{/if}
	{/foreach}
  </ol>
</nav>

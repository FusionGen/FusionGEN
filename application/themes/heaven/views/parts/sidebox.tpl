<!-- Sidebox.Start -->
{if $sideboxes}
	{foreach from=$sideboxes item=$sidebox}
	
		<div class="section-header">
			{if $sidebox.name == trim($sidebox.name) && str_contains($sidebox.name, ' ') !== false}
				{$names = explode(" ", $sidebox.name)}
				{for $i = 0; $i<count($names); $i++}
					{if $i % 2 == 1}<span>{$names[$i]}</span>{else}{$names[$i]}{/if}
				{/for}
			{else}
				{$sidebox.name}
			{/if}
		</div>
		
		<div class="section-body pb-5">
			{$sidebox.data}
		</div>
	{/foreach}
{/if}
<!-- Sidebox.End -->
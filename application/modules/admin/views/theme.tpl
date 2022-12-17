{foreach from=$themes item=manifest key=id}
	{if $manifest.folderName == $current_theme}
		<script type="text/javascript">
			
			function checkForTheme()
			{
				if(typeof Theme != "undefined")
				{
					Theme.scroll({$id});
				}
				else
				{
					setTimeout(checkForTheme, 50);
				}
			}

			checkForTheme();
		</script>
	{/if}
{/foreach}

<div class="owl-carousel owl-theme" id="theme_list">
		{foreach from=$themes item=manifest key=id}
		<div id="item theme_overflow">
			<img class="img-thumbnail" src="{$url}application/themes/{$manifest.folderName}/{$manifest.screenshot}" onClick="Theme.select('{strtolower($manifest.folderName)}')"/>
		</div>
		{/foreach}
</div>

<div class="col-lg">
	<div class="card">
		<header class="card-header d-flex justify-content-between"> 
			<h2 class="card-title">Themes</h2>
			<div class="card-actions">
				<span class="badge badge-primary" id="themes_count">{count($themes)}</span>
			</div>
		</header>
		<div class="card-body p-0">
			<table class="table table-hover m-0">
				<tbody id="all_themes">
					{foreach from=$themes item=manifest key=id}
						<tr class="border-top active" onClick="Theme.scroll({$id});" id="theme_{$id}">
							<td class="font-weight-bold border-0 align-middle text-light">
								<img src="{$url}application/themes/{strtolower($manifest.folderName)}/images/{$manifest.favicon}" />
								{ucfirst($manifest.name)}
							</td>
							<td class="font-weight-bold border-0 align-middle text-light"><a target="_blank" href="{$manifest.website}">{$manifest.author}</a></td>
							<td class="border-0 theme_action text-end">
								{if $manifest.folderName == $current_theme}
									<button id="btn-{{strtolower($manifest.folderName)}}" onClick="Theme.select('{strtolower($manifest.folderName)}')" class="btn btn-success btn-sm" disabled>Current</button>
								{else}
									<button id="btn-{{strtolower($manifest.folderName)}}" onClick="Theme.select('{strtolower($manifest.folderName)}')" class="btn btn-success btn-sm">Enable</button>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	<div class="text-center mt-2">
		<span class="font-weight-bold">Want a new look?</span> Get more themes from <a href="https://fusiongen.net/marketplace" target="_blank">the official FusionGEN marketplace</a>
	</div>
</div>

<script type="text/javascript">
	$('.owl-carousel').owlCarousel({
		"dots": true,
		"autoplay": true,
		"autoplayTimeout": 3000,
		"loop": true,
		"margin": 10,
		"nav": false,
		"responsive": {
			"0": {
				"items":1 
			}, 
			"600":{
				"items":3
			},
			"1000":{
				"items":6
			}
		} 
	})

</script>
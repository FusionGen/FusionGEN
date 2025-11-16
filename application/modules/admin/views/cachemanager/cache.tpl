<script>
	$(document).ready(function()
	{
		function checkIfLoaded()
		{
			if(typeof Fusion_Cache != "undefined")
			{
				Fusion_Cache.load();
			}
			else
			{
				setTimeout(checkIfLoaded, 50);
			}
		}
		checkIfLoaded();
	});
</script>

<section class="card">
	<header class="card-header">Cache</header>
	<div class="card-body">
	<span>
		You can manually clear cache to force database a reload of certain data. To minimize the server load, we recommended you to keep item cache intact, no matter how big it becomes.
	</span>

	<span id="cache_data">
		<div class="py-5 mx-5 list-inline">Loading cache, please wait<span class="p-0 d-inline" id="loading_dots">...</span></div>
	</span>

	{if hasPermission("emptyCache")}
		<button class="btn btn-primary btn-sm" onClick="Fusion_Cache.clear('item')">Clear item cache</button>
		<button class="btn btn-primary btn-sm" onClick="Fusion_Cache.clear('website')">Clear website cache</button>
		<button class="btn btn-primary btn-sm" onClick="Fusion_Cache.clear('all')">Clear all cache</button>
	{/if}
	</div>
</section>

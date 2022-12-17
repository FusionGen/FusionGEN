<script type="text/javascript">
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
		<li>Loading cache, please wait<span style="padding:0px;display:inline;" id="loading_dots">...</span></li>
	</span>

	{if hasPermission("emptyCache")}
		<span>
			<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Fusion_Cache.clear('all_but_item')">Clear item cache</a>&nbsp;
			<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Fusion_Cache.clear('website')">Clear website cache</a>&nbsp;
			<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Fusion_Cache.clear('all')">Clear all cache</a>
		</span>
	{/if}
	</div>
</section>
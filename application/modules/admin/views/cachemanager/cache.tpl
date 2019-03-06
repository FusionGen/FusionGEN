<script type="text/javascript">
	$(document).ready(function()
	{
		function checkIfLoaded()
		{
			if(typeof Cache != "undefined")
			{
				Cache.load();
			}
			else
			{
				setTimeout(checkIfLoaded, 50);
			}
		}

		checkIfLoaded();
	});
</script>

<section class="box big">
	<h2>Cache</h2>
	<span>
		You can manually clear cache to force database a reload of certain data. To minimize the server load, we recommended you to keep item cache intact no matter how big it becomes.
	</span>

	<ul id="cache_data">
		<li>Loading cache statistics, please wait<span style="padding:0px;display:inline;" id="loading_dots">...</li>
	</ul>

	{if hasPermission("emptyCache")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Cache.clear('all_but_item')"><b>Clear all but the item cache</b></a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Cache.clear('website')">Clear all website cache</a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Cache.clear('message')">Clear all message cache</a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Cache.clear('all')">Clear all cache</a>
		</span>
	{/if}
</section>
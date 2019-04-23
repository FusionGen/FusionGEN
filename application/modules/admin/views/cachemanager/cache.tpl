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

<section class="box big">
	<h2>Cache</h2>
	<span>
		You can manually clear Cache to force database a reload of certain data. To minimize the server load, we recommended you to keep item Cache intact no matter how big it becomes.
	</span>

	<ul id="Cache_data">
		<li>Loading Cache statistics, please wait<span style="padding:0px;display:inline;" id="loading_dots">...</li>
	</ul>

	{if hasPermission("emptyCache")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Fusion_Cache.clear('all_but_item')"><b>Clear all but the item Cache</b></a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Fusion_Cache.clear('website')">Clear all website Cache</a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Fusion_Cache.clear('message')">Clear all message Cache</a>&nbsp;
			<a class="nice_button" href="javascript:void(0)" onClick="Fusion_Cache.clear('all')">Clear all Cache</a>
		</span>
	{/if}
</section>
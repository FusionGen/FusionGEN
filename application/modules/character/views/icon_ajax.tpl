<span class="get_icon_{$id}">
	<div class='item'>
		<a></a>
		<img src="{$url}application/images/armory/default/loading.gif" />
	</div>
</span>

<script type="text/javascript">
	function Interval{$id}()
	{
		if(typeof Character != "undefined")
		{
			Character.getIcon({$id}, {$realm});
		}
		else
		{
			setTimeout(Interval{$id}, 100);
		}
	}

	$(document).ready(function()
	{
		Interval{$id}();
	});
</script>
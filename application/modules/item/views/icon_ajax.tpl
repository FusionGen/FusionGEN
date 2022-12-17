<span class="get_icon_{$id}">
	<div class='item'>
		<a></a>
		<img src="{$url}application/images/armory/default/loading.gif" />
	</div>
</span>

<script type="text/javascript">
	$(document).ready(function()
	{
		$.get(Config.URL + "icon/get/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".get_icon_" + {$id}).each(function()
	 		{
	 			$(this).html("<div class='item'><a></a><img src='https://wow.zamimg.com/images/wow/icons/large/" + data + ".jpg' /></div>");
	 		});
	 	});
	});
</script>
<span class="get_icon_{$id}">
	<img src="{$url}application/images/armory/default/loading.gif" width="18" height="18"/>
</span>

<script type="text/javascript">
	$(document).ready(function()
	{
		$.get(Config.URL + "icon/get/" + {$realm} + "/" + {$id}, function(data)
	 	{
	 		$(".get_icon_" + {$id}).each(function()
	 		{
	 			$(this).html("<img src='https://wow.zamimg.com/images/wow/icons/small/" + data + ".jpg' align='absmiddle'/>");
	 		});
	 	});
	});
</script>
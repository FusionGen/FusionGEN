var Orders = {

	search: function(type)
	{
		var string = $("#search_" + type).val();
		
		$("#donate_list_" + type).html('<center><img src="' + Config.URL + 'application/themes/admin/images/ajax.gif" /><br /><br /></center>');
	
		$.post(Config.URL + "store/admin_orders/search/" + type, {string: string, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#order_list_" + type).fadeOut(150, function()
			{
				$(this).html(data).slideDown(500, function()
				{
					Tooltip.refresh();
				});
			});
		});	
	},

	refund: function(id, element)
	{
		$(element).parents("li").slideUp(300, function()
		{
			$(this).remove();
		});

		$.get(Config.URL + "store/admin_orders/refund/" + id);
	}
}
var Donate = {

	search: function(type)
	{
		var string = $("#search_" + type).val();

		$("#donate_list_" + type).html('<i class="text-center fas fa-spinner fa-pulse fa-xl"></i>');

		$.post(Config.URL + "donate/admin/search/" + type, {string: string, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#donate_list_" + type).fadeOut(150, function()
			{
				$(this).html(data).slideDown(500, function()
				{
					Tooltip.refresh();
				});
			});
		});	
	}	
};

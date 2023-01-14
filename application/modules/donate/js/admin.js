var Donate = {
	
	search: function(type)
	{
		var string = $("#search_" + type).val();
		
		$("#donate_list_" + type).html('<i class="fa-solid fa-spinner fa-xl"></i>');
	
		$.post(Config.URL + "donate/admin/search/" + type, {string: string, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#donate_list_" + type).fadeOut(150, function()
			{
				$(this).html(data).slideDown(500, function()
				{
					$('[data-toggle="tooltip"]').tooltip();
				});
			});
		});	
	},

	give: function(id, field)
	{
		$("tr#paypal_id_"+ id +" td.paypal_valide").html("Manually compl.");

		$(field).parent().remove();

		$.get(Config.URL + "donate/admin/give/" + id, function(data)
		{
			console.log(data);
		});
	}
};
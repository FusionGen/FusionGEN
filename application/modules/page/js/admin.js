var Pages = {

	remove: function(id, element)
	{
		UI.confirm("Do you really want to delete this page?", "Yes", function()
		{
			$("#page_count").html(parseInt($("#page_count").html()) - 1);

			$(element).parents("li").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + "page/admin/delete/" + id);
		});
	},

	show: function()
	{
		if($("#pages").is(":visible"))
		{
			$("#pages").fadeOut(100, function()
			{
				$('#add_pages').fadeIn(100);
			});
		}
		else
		{
			$("#add_pages").fadeOut(100, function()
			{
				$('#pages').fadeIn(100);
			});
		}
	},

	send: function(id)
	{
		var data = {
			name: $("#headline").val(),
			identifier: $("#identifier").val(),
			rank_needed: $("#rank_needed").val(),
			content: $("#pages_content").html(),
			visibility: $("#visibility").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "page/admin/create" + ((id) ? "/" + id : ""), data, function(response)
		{
			if(response == "yes")
			{
				window.location = Config.URL + "page/admin";
			}
			else
			{
				UI.alert(response)
			}
		});
	}
}
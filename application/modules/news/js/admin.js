var News = {

	remove: function(id, element)
	{
		UI.confirm("Do you really want to delete this article?", "Yes", function()
		{
			$("#article_count").html(parseInt($("#article_count").html()) - 1);

			$(element).parents("li").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + "news/admin/delete/" + id);
		});
	},

	show: function()
	{
		if($("#news_articles").is(":visible"))
		{
			$("#news_articles").fadeOut(100, function()
			{
				$('#add_news').fadeIn(100);
			});
		}
		else
		{
			$("#add_news").fadeOut(100, function()
			{
				$('#news_articles').fadeIn(100);
			});
		}
	},

	send: function(id)
	{
		var data = {
			headline: $("#headline").val(),
			avatar: $("#avatar").is(":checked"),
			comments: $("#comments").is(":checked"),
			content: $("#news_content").html(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "news/admin/create" + ((id) ? "/" + id : ""), data, function(response)
		{
			if(response == "yes")
			{
				window.location = Config.URL + "news/admin";
			}
			else
			{
				UI.alert(response)
			}
		});
	}
}
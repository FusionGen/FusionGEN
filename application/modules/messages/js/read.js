var Read = {
	
	reply: function(id)
	{
		var content = $("#pm_editor").html();

		if(content.length <= 3)
		{
			UI.alert("Message must be longer than 3 characters!");
		}
		else
		{	
			$("#pm_form").fadeOut(300, function()
			{
				$(this).html('<a class="nice_button" href="' + Config.URL + 'messages">&larr; ' + lang("inbox", "messages") + '</a>').fadeIn(300);
			});

			$("#pm_spot_ajax").html('<div style="text-align:right;margin-bottom:10px;"><img src="' + Config.image_path + 'ajax.gif" /></div>');

			$.post(Config.URL + "messages/read/reply/" + id, {content:content, csrf_token_name: Config.CSRF}, function(data)
			{
				$("#pm_spot_ajax").fadeOut(300, function()
				{
					var date = new Date(),
						y = date.getFullYear(),
						m = date.getMonth(),
						d = date.getDay();
						
					$("#pm_date").html(y + "/" + m + "/" + d);
					$("#pm_message").html(data);
					$("#pm_spot_message").show(150);
				});
			});
		}
	}
}
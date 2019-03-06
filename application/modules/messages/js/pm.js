var Messages = {

	showTab: function(id, element)
	{
		$(".nice_active").removeClass("nice_active");
		$(element).addClass("nice_active");

		$(".pm_spot").hide();
		$("#pm_" + id).show();

		if(id == "inbox")
		{
			$("#pm_empty").html("Empty inbox").attr("onClick", "Messages.clearInbox()");
		}
		else if(id == "sent")
		{
			$("#pm_empty").html("Empty sent").attr("onClick", "Messages.clearSent()");
		}
	},

	clearInbox: function()
	{
		UI.confirm("Empty inbox?", "Yes", function()
		{
			$("#pm_inbox").html('<div style="text-align:center;padding:10px;">' + lang("deleting", "messages") + '...</div>');

			$.get(Config.URL + "messages/clear", function()
			{
				$("#pm_inbox").html('<div style="text-align:center;padding:10px;">' + lang("no_messages", "messages") + '.</div>');
			});
		});
	},

	clearSent: function()
	{
		UI.confirm("Empty sent?", "Yes", function()
		{
			$("#pm_sent").html('<div style="text-align:center;padding:10px;">' + lang("deleting", "messages") + '...</div>');

			$.get(Config.URL + "messages/clearSent", function()
			{
				$("#pm_sent").html('<div style="text-align:center;padding:10px;">' + lang("no_messages", "messages") + '.</div>');
			});
		});
	}
}
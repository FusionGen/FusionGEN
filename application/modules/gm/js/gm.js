var Gm = {
	
	view: function(field)
	{
		var ticket = $(field).parents(".gm_ticket");

		ticket.children(".gm_ticket_info").slideUp(300, function()
		{
			ticket.children(".gm_ticket_info_full").slideDown(300, function()
			{
				ticket.children(".gm_tools").fadeIn(300);
			});
		});
	},

	hide: function(field)
	{
		var ticket = $(field).parents(".gm_ticket");

		ticket.children(".gm_tools").fadeOut(300, function()
		{
			ticket.children(".gm_ticket_info_full").slideUp(300, function()
			{
				ticket.children(".gm_ticket_info").slideDown(300);
			});
		});
	},

	ban: function()
	{
		var html = '<input type="text" id="ban_account" placeholder="' + lang("account_name", "gm") + '" value=""/><br /><input type="text" id="reason" placeholder="' + lang("ban_reason", "gm") + '" value=""/>';

		UI.confirm(html, "Ban", function()
		{
			var account = $("#ban_account").val();
			var reason = $("#reason").val();

			$.post(Config.URL + "gm/ban/" + account, {reason: reason, csrf_token_name: Config.CSRF}, function(data)
			{
				UI.alert(lang("account", "gm") + " " + account + " " + lang("has_been_banned", "gm"));
			});
		});
	},

	kick: function(realm)
	{
		var html = '<input type="text" id="kick_character" placeholder="' + lang("character_name", "gm") + '" value=""/>';

		UI.confirm(html, lang("kick_short", "gm"), function()
		{
			var character = $("#kick_character").val();
			
			$.get(Config.URL + "gm/kick/" + realm + "/" + character, function(data)
			{
				UI.alert(lang("character_has_been_kicked", "gm"));
			});
		});
	},

	close: function(realm, id, field)
	{
		UI.confirm(lang("close_ticket", "gm"), lang("close_short", "gm"), function()
		{
			$(field).parents(".gm_ticket").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + "gm/close/" + realm + "/" + id);
		});
	},

	answer: function(realm, id, field)
	{
		var html = '<textarea id="answer_message" style="width:90%" maxlength="7999"></textarea>';

		UI.confirm(html, lang("send", "gm"), function()
		{
			var message = $("#answer_message").val();

			$.post(Config.URL + "gm/answer/" + realm + "/" + id, {csrf_token_name: Config.CSRF, message:message}, function(data)
			{
				console.log(data);
				UI.alert(lang("mail_sent", "gm"));
			});
		});
	},

	unstuck: function(realm, id, field)
	{
		$.post(Config.URL + "gm/unstuck/" + realm + "/" + id, {csrf_token_name: Config.CSRF}, function(data)
		{
			console.log(data);

			if(data == '1')
			{
				UI.alert(lang("teleported", "gm"));
			}
			else
			{
				UI.alert(lang("must_be_offline", "gm"));
			}
		});
	},

	sendItem: function(realm, id, field)
	{
		var html = '<input type="text" id="item_id" placeholder="Item ID" value=""/>';

		UI.confirm(html, "Send", function()
		{
			var item = $("#item_id").val();

			$.post(Config.URL + "gm/sendItem/" + realm + "/" + id, {csrf_token_name: Config.CSRF, item:item}, function(data)
			{
				UI.alert(lang("item_sent", "gm"));
			});
		});
	}
}
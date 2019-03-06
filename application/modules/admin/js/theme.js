var Theme = {
	
	count: false,

	initialize: function()
	{
		Theme.count = $("#theme_overflow a").length;
	},

	scroll: function(to)
	{
		// Arrays start on 0 - CSS selctors don't.
		to = to + 1;

		if(Theme.count == false)
		{
			Theme.initialize();
		}

		var margin = -(248 * (to - 2)) - 25;

		$("#theme_overflow").css({marginLeft:margin});
		$("#theme_overflow img:not(:nth-child(" + to + "))").transition({scale:0.85,opacity:0.7,perspective:'233px',rotateY: '0deg'}, 500);
		$("#theme_overflow img:nth-child(" + to + ")").transition({scale:1,opacity:1,perspective:'233px',rotateY: '10deg'}, 500);

		$(".active_theme").removeClass("active_theme");
		$("#theme_" + (to - 1)).addClass("active_theme");
	},

	select: function(name)
	{
		$('#theme_list_text').html('<h2><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_picture.png"/> Themes</h2><span id="theme_ajax_spot">Activating theme...</span>');

		$.get(Config.URL + "admin/theme/set/" + name, function(data)
		{
			if(data == "yes")
			{
				UI.alert('The theme has been changed!', 1000);
				Router.load(Config.URL + "admin/theme/");
			}
			else
			{
				UI.alert(data, 1000);
				Router.load(Config.URL + "admin/theme/");
			}
		});
	}
}
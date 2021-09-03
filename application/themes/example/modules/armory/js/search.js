var Search = {
	current: null,
	isAnimated: false,

	/**
	 * Get search results
	 */
	submit: function()
	{
		var results = $("#search_results");
		var value = $("#search_field").val();

		if(value.length > 0)
		{
			if(value != Search.current)
			{
				Search.current = value;

				results.hide().html('<center><img src="' + Config.image_path + 'ajax.gif" /></center>').fadeIn(200, function()
				{
					Search.isAnimated = false;

					$("#search_box").animate({width:"100%",marginTop:0,marginBottom:0}, 300, function()
					{
						Search.isAnimated = true;
					});

					$.post(Config.URL + "armory/search", {search: value, csrf_token_name: Config.CSRF}, function(data)
					{
						Search.showSearch(data);
					});
				});
			}
		}
		else
		{
			UI.alert(lang("cant_be_empty", "armory"));
		}
	},

	showSearch: function(data)
	{
		if(!Search.isAnimated)
		{
			setTimeout(function(){Search.showSearch(data)}, 20);
		}
		else
		{
			var results = $("#search_results");

			results.fadeOut(100, function()
			{
				results.html(data).fadeIn(100, function()
				{
					Tooltip.refresh();
					Router.initialize();
				});
			});
		}
	},

	/**
	 * Change to a tab
	 * @param Int tab
	 */
	showTab: function(tab, element)
	{
		$(".search_link").removeClass("nice_active");
		$(".search_link").removeClass("search_link");

		$(element).addClass("nice_active");
		$(element).addClass("search_link");

		$(".search_tab").hide();

		$(".search_realm").addClass("nice_active");
		$(".search_result_item").show();

		$("#search_tab_" + tab).fadeIn(500);
	},

	/**
	 * Toggle the visiblity of content of a realm
	 * @param Int realm
	 * @param Element field
	 */
	 toggleRealm: function(realm, field)
	 {
	 	var obj = $(field);
	 	
	 	if(obj.hasClass("nice_active"))
	 	{
	 		obj.removeClass("nice_active");
	 		$(".search_result_realm_" + realm).hide();
	 	}
	 	else
	 	{
	 		obj.addClass("nice_active");
	 		$(".search_result_realm_" + realm).show();
	 	}
	 }
}
var Slider = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "slider",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "admin/slider/delete/",
		create: "admin/slider/create/",
		save: "admin/slider/save/",
		move: "admin/slider/move/"
	},

	/**
	 * Removes an entry from the list
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function(id, element)
	{
		var identifier = this.identifier,
			removeLink = this.Links.remove;

		UI.confirm("Do you really want to delete this " + identifier + "?", "Yes", function()
		{
			$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - 1);

			$(element).parents("li").slideUp(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + removeLink + id);
		});
	},

	/**
	 * Toggle between the "add" form and the list
	 */
	add: function()
	{
		var id = this.identifier;

		if($("#add_" + id).is(":visible"))
		{
			$("#add_" + id).fadeOut(150, function()
			{
				$("#main_" + id).fadeIn(150);
			});
		}
		else
		{
			$("#main_" + id).fadeOut(150, function()
			{
				$("#add_" + id).fadeIn(150);
			});
		}
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.create, values, function(data)
		{
			console.log(data);
			eval(data);
		});
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			console.log(data);
			eval(data);
		});
	},

	/**
	 * Move up/down
	 * @param String direction
	 * @param Int id
	 * @param Object element
	 */
	move: function(direction, id, element)
	{
		var row = $(element).parents("li");
		var targetRow = (direction == "up") ? row.prev("li") : row.next("li");

		if(targetRow.length)
		{
			$.get(Config.URL + this.Links.move + id + "/" + direction, function(data)
			{
				console.log(data);
			});

			row.hide(300, function()
			{
				if(direction == "down")
				{
					targetRow.after(row);
				}
				else
				{
					targetRow.before(row);
				}

				row.slideDown(300);
			});
		}
	},

	/**
	 * ----------- Module specific code -----------
	 */

	saveSettings: function(form)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + "admin/slider/saveSettings", values, function(data)
		{
			console.log(data);
			eval(data);
		});
	}
}
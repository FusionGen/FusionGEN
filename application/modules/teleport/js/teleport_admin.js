var Teleport = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "teleport",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "teleport/admin/delete/",
		create: "teleport/admin/create/",
		save: "teleport/admin/save/",
		move: "teleport/admin/move/"
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

		UI.confirm("Do you really want to delete this location?", "Yes", function()
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
	 * ----------- Module specific code -----------
	 */
	changePrice: function(select)
	{
		$("#vpCost").val("0");
		$("#dpCost").val("0");
		$("#goldCost").val("0");
				
		switch(select.value)
		{
			case "free":
				$("#vp_price").fadeOut(300);
				$("#dp_price").fadeOut(300);
				$("#gold_price").fadeOut(300);
			break;


			case "vp":
				if($("#gold_price").is(":visible"))
				{
					$("#gold_price").fadeOut(300, function()
					{
						$("#vp_price").fadeIn(300);
					});
				}
				else
				{
					$("#dp_price").fadeOut(300, function()
					{
						$("#vp_price").fadeIn(300);
					});
				}
			break;

			case "dp":
				if($("#gold_price").is(":visible"))
				{
					$("#gold_price").fadeOut(300, function()
					{
						$("#dp_price").fadeIn(300);
					});
				}
				else
				{
					$("#vp_price").fadeOut(300, function()
					{
						$("#dp_price").fadeIn(300);
					});
				}
			break;

			case "gold":
				if($("#vp_price").is(":visible"))
				{
					$("#vp_price").fadeOut(300, function()
					{
						$("#gold_price").fadeIn(300);
					});
				}
				else
				{
					$("#dp_price").fadeOut(300, function()
					{
						$("#gold_price").fadeIn(300);
					});
				}
			break;
		}
	}
}
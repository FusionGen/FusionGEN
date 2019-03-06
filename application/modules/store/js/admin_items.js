var Items = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "item",

	/**
	 * The ID of the fusionEditor (like "#news_content"), if any, otherwise put false
	 */
	fusionEditor: false,

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "store/admin_items/delete/",
		create: "store/admin_items/create/",
		createGroup: "store/admin_items/createGroup/",
		save: "store/admin_items/save/"
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

	removeGroup: function(id, element)
	{
		UI.confirm("Do you really want to delete this group and all of it's items?", "Yes", function()
		{
			$.get(Config.URL + "store/admin_items/deleteGroup/" + id, function()
			{
				window.location.reload(true);
			});
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

	addGroup: function()
	{
		var id = this.identifier;

		if($("#add_group").is(":visible"))
		{
			$("#add_group").fadeOut(150, function()
			{
				$("#main_" + id).fadeIn(150);
			});
		}
		else
		{
			$("#main_" + id).fadeOut(150, function()
			{
				$("#add_group").fadeIn(150);
			});
		}
	},

	/**
	 * Submit the form contents to the create link
	 * @param Object form
	 */
	create: function(form, isGroup)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, select, textarea").each(function()
		{
			if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
			else if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		if(this.fusionEditor != false)
		{
			values[this.fusionEditor.replace("#", "")] = $(this.fusionEditor).html();
		}

		$.post(Config.URL + ((isGroup)?this.Links.createGroup:this.Links.create), values, function(data)
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

		$(form).find("input, select, textarea").each(function()
		{
			if($(this).attr("type") == "checkbox")
			{
				values[$(this).attr("name")] = this.checked;
			}
			else if($(this).attr("type") != "submit")
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

	groupActions: function()
	{
		if(typeof formType != "undefined")
		{
			Items.formType = formType;
		}
		
		$(".item_group").each(function()
		{
			$(this).hover(
				function()
				{
					$(this).find(".group_title").hide(0, function()
					{
						$(this).siblings(".group_order").hide(0);
						$(this).siblings(".group_actions").show(0);
					});
				},
				function()
				{
					$(this).find(".group_actions").hide(0, function()
					{
						$(this).siblings(".group_order").show(0);
						$(this).siblings(".group_title").show(0);					
					});
				}
			);
		});
	},

	editGroup: function(id, field)
	{
		var nameField = $(field).parents("div").siblings(".group_title");
		var orderField = $(field).parents("div").siblings(".group_order").find(".group_order_number");

		var renameHTML = "<input placeholder='Title' type='text' id='rename'><br/><input value='"+orderField.html()+"' placeholder='Number to order' type='text' id='order'>";

		UI.confirm(renameHTML, "Save", function()
		{
			var name = $("#rename").val();
			var number = $("#order").val();

			nameField.html(name);
			orderField.html(number);

			$.post(Config.URL + "store/admin_items/saveGroup/" + id, {csrf_token_name:Config.CSRF, title:name, order:number}, function()
			{
				console.log("EXECUTED");
				//window.location.reload(true);
			});
		});

		$("#rename").val(nameField.html());
	},

	formType: "item",
	
	fadeFormIn: function(name)
	{
		Items.formType = name;

		$("#" + name + "_form").fadeIn(300);
	},

	changeType: function(select)
	{
		switch(select.value)
		{
			case "item":
				if($("#query_form").is(":visible"))
				{
					$("#query_form").fadeOut(300, this.fadeFormIn("item"));
				}
				else if($("#command_form").is(":visible"))
				{
					$("#command_form").fadeOut(300, this.fadeFormIn("item"));
				}
			break;

			case "command":
				if($("#query_form").is(":visible"))
				{
					$("#query_form").fadeOut(300, this.fadeFormIn("command"));
				}
				else if($("#item_form").is(":visible"))
				{
					$("#item_form").fadeOut(300, this.fadeFormIn("command"));
				}
			break;

			case "query":
				if($("#item_form").is(":visible"))
				{
					$("#item_form").fadeOut(300, this.fadeFormIn("query"));
				}
				else if($("#command_form").is(":visible"))
				{
					$("#command_form").fadeOut(300, this.fadeFormIn("query"));
				}
			break;
		}
	}
}

$(document).ready(Items.groupActions);
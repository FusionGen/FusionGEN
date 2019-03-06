var Changelog = {
	
	/**
	 * General identifier used on #{ID}_count, #add_{ID}, #{ID}_list and #main_{ID}
	 */
	identifier: "changelog",

	/**
	 * Links for the ajax requests
	 */
	Links: {
		remove: "changelog/admin/delete/",
		removeCategory: "changelog/admin/deleteCategory/",
		create: "changelog/admin/create/",
		save: "changelog/admin/save/",
		saveCategory: "changelog/admin/saveCategory/",
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
	add: function(categoryId)
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

		$.post(Config.URL + this.Links.create, values, function()
		{
			window.location.reload(true);
		});
	},

	/**
	 * Submit the form contents to the save link
	 * @param Object form
	 */
	save: function(form, id)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).find("input, textarea, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + this.Links.save + id, values, function(data)
		{
			window.location = Config.URL + "changelog/admin";
		});
	},

	/**
	 * ----------- Module specific code -----------
	 */
	addChange: function(id)
	{
		var addHTML = '<textarea id="change_message" rows="4" placeholder="Changelog message..."></textarea>';

		UI.confirm(addHTML, "Submit", function()
		{
			var change_message = $("#change_message").val();

			$.post(Config.URL + "changelog/admin/addChange/" + id, {csrf_token_name:Config.CSRF, change_message:change_message}, function(data)
			{
				data = JSON.parse(data);
				console.log(data);
				$("#headline_" + id).after('<li style="display:none;">' +
						'<table width="100%">' +
							'<tr>' +
								'<td width="40%">' + data.changelog +'</td>' +
								'<td width="20%">' + data.author + '</td>' +
								'<td width="20%">' + data.date + '</td>' +
								'<td style="text-align:right;" width="10%">' +
									'<a href="' + Config.URL + 'changelog/admin/edit/' + data.id + '" data-tip="Edit"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;'+
									'<a href="javascript:void(0)" onClick="Changelog.remove(' + data.id + ', this)" data-tip="Delete"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>'+
								'</td>' +
							'</tr>' +
						'</table>' +
					'</li>');
				$("#headline_" + id).next().slideDown(300);
			});
		});
	},

	/**
	 * Removes a category
	 * @param  Int id
	 * @param  Object element
	 */
	removeCategory: function(id, element)
	{
		var identifier = this.identifier,
			removeLink = this.Links.removeCategory;

		UI.confirm("Do you really want to delete this category and all it's entries?", "Yes", function()
		{
			var entries = $(element).parents("ul").children("li").length - 1;

			$("#" + identifier + "_count").html(parseInt($("#" + identifier + "_count").html()) - entries);

			$(element).parents("ul").fadeOut(300, function()
			{
				$(this).remove();
			});

			$.get(Config.URL + removeLink + id);
		});
	},

	renameCategory: function(id, field)
	{
		var nameField = $(field).parents("td").prev("td").children("b");

		var renameHTML = "<input type='text' id='rename' value=" + nameField.html() + ">";

		UI.confirm(renameHTML, "Save", function()
		{
			var name = $("#rename").val();

			nameField.html(name);

			$.post(Config.URL + Changelog.Links.saveCategory + id, {csrf_token_name:Config.CSRF, typeName:name});
		});
	}
}
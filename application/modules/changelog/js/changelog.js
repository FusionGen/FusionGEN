var Changelog = {

	addChange: function()
	{
		var changeTypeId = $("#changelog_types").val();
		var changeText = $("#change_text").val();

		if(changeText.length > 0)
		{
			$.post(Config.URL + "changelog/addChange", {change:changeText, category: changeTypeId, csrf_token_name: Config.CSRF}, function(id)
			{
				$("#change_text").val('');

				var typeText = $("#changelog_types option[value='" + $("#changelog_types").val() + "']").html();
				var changelogArea = $("#changelog");
				var dateText = Changelog.formatDate(new Date());
				var typeHTML = '<tr id="change_' + typeText + '">' +
									'<td><a>' + typeText + '</a></td>' +
								'</tr>';
				var dateHTML = '<tr id="my_date">' +
									'<td><div class="changelog_info">' + lang("changes_made_on", "changelog") + ' ' + dateText + '</div></td>' +
								'</tr>';
				var changeHTML = '<tr>' +
									'<td><a href="' + Config.URL + 'changelog/remove/' + id + '" style="display:inline !important;margin:0px !important;"><img src="' + Config.URL + 'application/images/icons/delete.png" align="absmiddle" /></a> &nbsp;' + changeText + '</td>' +
								'</tr>';

				// Remove the "There are no changes to show." message
				if(changelogArea.children('table').length == 0)
				{
					// Add the entry
					var output = '<table class="nice_table">' +
									dateHTML +
									typeHTML +
									changeHTML +
								'</table>';

					changelogArea.html(output);
				}
				else
				{
					var dateElement = false;

					// Loop through all date groups
					changelogArea.children('table').each(function()
					{
						// Does one exist with the current date?
						if($(this).find('.changelog_info').html() == "Changes made on " + dateText)
						{
							// Use it
							dateElement = $(this).find('.changelog_info').parent().parent();
						}
					});

					if(dateElement == false)
					{
						// If not, create one
						changelogArea.prepend('<table class="nice_table">' +
												dateHTML +
											'</table>');

						dateElement = $("#my_date");
					}

					var typeElement = false;

					// Search the type groups for the same one
					dateElement.parent().find('td a').each(function()
					{
						if($(this).html() == typeText)
						{
							typeElement = $(this).parent().parent();
						}
					});

					if(typeElement == false)
					{
						dateElement.after(typeHTML);
						typeElement = $("#change_" + typeText);
					}

					typeElement.after(changeHTML);
				}
			});
		}
	},

	formatDate: function(date)
	{
		var year = date.getFullYear();
		var month = ((date.getUTCMonth() + 1) < 10) ? "0" + (date.getUTCMonth() + 1): (date.getUTCMonth() + 1);
		var day = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();

		return year + "/" + month + "/" + day;
	}
}
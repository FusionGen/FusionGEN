/**
 * [MLI] MultiLanguageInput
 * @package FusionCMS
 * @version 6.1
 * @author Jesper Lindström
 * @link http://fusion-hub.com
 */

function MultiLanguageInput(field)
{
	var originalData = field.val(),
		isJson = true,
		data = {},
		area;

	/**
	 * Start it all; assign events and so on
	 */
	var initialize = function()
	{
		field.prop("type", "hidden");
		field.after('<div class="languages"></div>');

		area = field.next('.languages');

		// Check if it's JSON or not
		try
		{
			data = JSON.parse(originalData);

			for(var i in data)
			{
				area.append(createField(i, data[i]));
			}
		}
		catch(exception)
		{
			isJson = false;
			data = {};
			data[Config.defaultLanguage] = originalData;
			field.val(JSON.stringify(data));
			area.append(createField(Config.defaultLanguage, originalData));
		}

		var addTranslation = $('<a href="javascript:void(0)">(add translation)</a>');

		addTranslation.on('click', function()
		{
			var options = getLanguageOptions();

			var languages = '<select id="insertLanguage">' + options + '</select>';

			if(options)
			{
				UI.confirm(languages, 'Insert', function()
				{
					data[$("#insertLanguage").val()] = "";
					area.append(createField($("#insertLanguage").val()));
				});
			}
			else
			{
				UI.alert("There are no more languages");
			}
		});

		field.prev("label").append(" ").append(addTranslation);
	};

	var getLanguageOptions = function()
	{
		var html = "";

		Config.languages.forEach(function(language)
		{
			if(typeof data[language] == "undefined")
			{
				html += "<option value='" + language + "'>" + language + "</option>";
			}
		});

		return html;
	};

	/**
	 * Create the element for a text field
	 * @param String language
	 * @param String text
	 */
	var createField = function(language, text)
	{
		if(!text)
		{
			var text = "";
		}

		var newField = $("<input type='text' data-lang='" + language + "' style='padding-left:70px;' value='" + text + "'/>");

		// Assign blur event
		newField.on('blur', function()
		{
			// Update the data
			data[language] = $(this).val();	
			field.val(JSON.stringify(data));
		});

		var flag = '<div style="position:absolute;margin-top:11px;margin-left:10px;font-weight:bold;font-size:12px;">' + language + '</div>';

		return [flag, newField];
	};

	// Start it all
	initialize();
}

/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geernick
 * @link http://fusion-hub.com
 */

var Settings = {

	wrongPassword: null,
	canSubmit: true,

	submit: function()
	{
		// Client-side validation of the passwords
		if($("#new_password").val() !== $("#new_password_confirm").val())
		{
			if(Settings.canSubmit)
			{
				UI.alert(lang("pw_doesnt_match", "ucp"));
				Settings.canSubmit = false;
			}
		}
		else if(Settings.wrongPassword != null && Settings.wrongPassword == $("#old_password").val())
		{
			return false;
		}
		else
		{
			Settings.canSubmit = true;

			// Show that we're loading something
			$("#settings_ajax").html('<img src="' + Config.image_path + 'ajax.gif" />');

			// Gather the values
			var values = {
				old_password: $("#old_password").val(),
				new_password: $("#new_password").val(),
				csrf_token_name: Config.CSRF
			};

			// Submit the request
			$.post(Config.URL + "ucp/settings/submit", values, function(data)
			{
				if(/yes/.test(data))
				{
					$("#settings_ajax").html(lang("changes_saved", "ucp"));
				}
				else if(/no/.test(data))
				{
					$("#settings_ajax").html('');

					UI.alert(lang("invalid_pw", "ucp"));

					Settings.wrongPassword = $("#old_password").val();
				}
				else
				{
					$("#settings_ajax").html(data);
				}
			});
		}
	},

	submitInfo: function()
	{
		var value = $("#nickname_field").val(),
			loc = $("#location_field").val(),
			language;

		if($("#language_field"))
		{
			language = $("#language_field").val();
		}
		else
		{
			language = 0;
		}

		if(value.length < 4 || value.length > 14)
		{
			UI.alert(lang("nickname_error"));
		}
		else if(loc.length > 14)
		{
			UI.alert(lang("location_error"));
		}
		else
		{
			// Show that we're loading something
			$("#settings_info_ajax").html('<img src="' + Config.image_path + 'ajax.gif" />');

			// Submit the request
			$.post(Config.URL + "ucp/settings/submitInfo",
			{
				nickname: value,
				location: loc,
				language: language,
				csrf_token_name: Config.CSRF
			},
			function(data)
			{
				if(/1/.test(data))
				{
					$("#settings_info_ajax").html(lang("changes_saved", "ucp"));

					if(language)
					{
						window.location.reload(true);
					}
				}
				else if(/2/.test(data))
				{
					$("#settings_info_ajax").html('');
					UI.alert(lang("nickname_taken", "ucp"));
				}
				else if(/3/.test(data))
				{
					$("#settings_info_ajax").html('');
					UI.alert(lang("invalid_language", "ucp"));
				}
				else
				{
					$("#settings_info_ajax").html(data);
				}
			});
		}
	}
}
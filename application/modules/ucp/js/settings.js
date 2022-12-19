
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
				Swal.fire({
					text: lang("pw_doesnt_match", "ucp"),
					icon: 'error',
					target: 'body',
					toast: true,
					position: 'bottom-right',
					timer: 10000,
					timerProgressBar: true,
					showConfirmButton: false,
				});
				
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
			$("#settings_ajax").html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

			// Gather the values
			var values = {
				old_password: $("#old_password").val(),
				new_password: $("#new_password").val(),
				csrf_token_name: Config.CSRF
			};

			// Submit the request
			$.post(Config.URL + "ucp/settings/submit", values, function(data)
			{
				$("#settings_ajax").html('');
				
				if(/yes/.test(data))
				{
					Swal.fire({
						text: lang("changes_saved", "ucp"),
						icon: 'success',
						target: 'body',
						toast: true,
						position: 'bottom-right',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
						willClose: () => {
							window.location.reload(true);
						}
					});
				}
				else if(/no/.test(data))
				{
					Swal.fire({
						text: lang("invalid_pw", "ucp"),
						icon: 'error',
						target: 'body',
						toast: true,
						position: 'bottom-right',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
					});

					Settings.wrongPassword = $("#old_password").val();
				}
				else
				{
					Swal.fire({
						text: data,
						icon: 'error',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
					});
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
			Swal.fire({
				text: lang("nickname_error", "ucp"),
				icon: 'error',
				target: 'body',
				toast: true,
				position: 'bottom-right',
				timer: 10000,
				timerProgressBar: true,
				showConfirmButton: false,
			});
		}
		else if(loc.length > 32)
		{
			Swal.fire({
				text: lang("location_error", "ucp"),
				icon: 'error',
				target: 'body',
				toast: true,
				position: 'bottom-right',
				timer: 10000,
				timerProgressBar: true,
				showConfirmButton: false,
			});
		}
		else
		{
			// Show that we're loading something
			$("#settings_info_ajax").html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

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
				$("#settings_info_ajax").html("");
				if(/1/.test(data))
				{					
					Swal.fire({
						text: lang("changes_saved", "ucp"),
						icon: 'success',
						target: 'body',
						toast: true,
						position: 'bottom-right',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
						willClose: () => {
							window.location.reload(true);
						}
					});
				}
				else if(/2/.test(data))
				{					
					Swal.fire({
						text: lang("nickname_taken", "ucp"),
						icon: 'error',
						target: 'body',
						toast: true,
						position: 'bottom-right',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
					});
				}
				else if(/3/.test(data))
				{
					Swal.fire({
						text: lang("invalid_language", "ucp"),
						icon: 'error',
						target: 'body',
						toast: true,
						position: 'bottom-right',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
					});
				}
				else
				{
					Swal.fire({
						text: data,
						icon: 'error',
						timer: 10000,
						timerProgressBar: true,
						showConfirmButton: false,
					});
				}
			});
		}
	}
}
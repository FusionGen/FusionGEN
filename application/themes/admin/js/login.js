var Login = {
	
	send: function(form)
	{
		var values = {csrf_token_name: Config.CSRF, send:"1"};

		$(form).find("input[type='text'], input[type='password']").each(function()
		{
			values[$(this).attr("id")] = $(this).val();
		});

		$.post(Config.URL + "admin", values, function(data)
		{
			switch(data)
			{
				case "username":
					$("#security_code").removeClass("error");
					$("#username").addClass("error");
					$("#password").addClass("error");
				break;

				case "password":
					$("#security_code").removeClass("error");
					$("#username").attr("disabled", "disabled").removeClass("error");
					$("#password").addClass("error");
				break;

				case "key":
					$("#security_code").addClass("error");
					$("#username").attr("disabled", "disabled").removeClass("error");
					$("#password").attr("disabled", "disabled").removeClass("error");
				break;

				case "permission":
					$("#security_code").attr("disabled", "disabled").removeClass("error");
					$("#username").attr("disabled", "disabled").removeClass("error");
					$("#password").attr("disabled", "disabled").removeClass("error");

					alert("You do not have permission to access the admin panel (assign permission: [view, admin])");
				break;

				case "welcome":
					$("#security_code").attr("disabled", "disabled").removeClass("error");
					$("#username").attr("disabled", "disabled").removeClass("error");
					$("#password").attr("disabled", "disabled").removeClass("error");

					window.location.reload(true);
				break;

				default:
					console.log(data);
				break;
			}
		});
	}
};
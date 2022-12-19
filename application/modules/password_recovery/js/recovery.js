var Recovery = {	
	get: function() 
	{
		var value = {csrf_token_name: Config.CSRF};
		var account = $("input#recovery").val();

		value['account'] = account;

		$.post(Config.URL + "password_recovery/createRequest/" + account, value, function(response)
		{
			Swal.fire({
				icon: "success",
				text: lang("email_sent", "recovery"),
			});
		})
	}
}
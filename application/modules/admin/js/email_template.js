var Template = {
	save: function(id)
	{
		var data = {
			code:$("#code").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/email_template/save/" + id, data, function(response)
		{
			if(response == "yes")
			{
				Swal.fire({
					theme: 'dark',
					title: "Template has been saved!",
					icon: "success",
				});
			}
			else
			{
				Swal.fire({
					theme: 'dark',
					title: 'Oops...',
					text: response,
					icon: 'error',
				})
			}
		});
	}
}

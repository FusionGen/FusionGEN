var Support = {
	create: function()
	{
		var values = {
			csrf_token_name: Config.CSRF
		};
		
		Swal.fire({
			title: 'Do you really want to create a request?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
		if (result.isConfirmed) {
			$.post(Config.URL + "admin/support/create_request", values, function(data)
			{
				console.log(data);
				try {
					data = JSON.parse(data);
					if(data['status'] == true) {
						Swal.fire({
							icon: "success",
							title: data['message'],
						});
					} else {
						Swal.fire({
							icon: "error",
							title: data['message'],
						});
						return;
					}
				} catch(e) {
					console.error(e);
					return;
				}
			});
		}
		})
	}
}
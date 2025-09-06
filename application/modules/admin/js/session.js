var Session = {

	/**
	 * Removes all sessions
	 */
	delete: function(id, element)
	{
		var data = {
			csrf_token_name: Config.CSRF
		};

		Swal.fire({
			theme: 'dark',
			title: 'Are you sure?',
			text: 'This will delete all sessions except those with your IP',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		if (result.isConfirmed) {
			Swal.fire({
				theme: 'dark',
				title: 'Deleted!',
				text: '',
				icon: 'success',
			})
			$.post(Config.URL + 'admin/sessions/deleteSessions', data, function(data)
			{
				if(data == '1')
				{
					window.location.reload(true);
				}
				else
				{
					Swal.fire({
						theme: 'dark',
						title: 'Oops...',
						text: data,
						icon: 'error',
					})
				}
			});
		}
		})
	}
}

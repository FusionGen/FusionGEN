var UpdateCMS = {
	update: function()
		{
			var values = {
				csrf_token_name: Config.CSRF
			};
			
			$( "#updatelog" ).html("<hr>");
			
			$.post(Config.URL + "admin/updater/install_updates", values, function(response)
			{
				console.log(response);
				$( "#updatelog" ).append(response);
			});
		}
}
var Ajax = {
	initialize: function()
	{
		$.get("do_realms.php?step=getEmulators", function(data)
		{
			data = JSON.parse(data);

			$("#emulator").html("");

			$.each(data, function(key, value)
			{
				$("#emulator").append('<option value=' + key + '>' + value + '</option>');
			});
		});
	}
}
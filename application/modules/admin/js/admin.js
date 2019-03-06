var Admin = {

	enableModule: function(moduleId, element)
	{
		$.post(Config.URL + 'admin/enable/' + moduleId, {csrf_token_name: Config.CSRF}, function(data)
		{
			if(data == 'SUCCESS')
			{
				$(element).attr("onClick", "Admin.disableModule(" + moduleId + ", this)").html("Disable");
				
				var parent = $(element).parent();

				$("#enabled_modules").append(parent[0]);
				$("#disabled_count").html(parseInt($("#disabled_count").html()) - 1);
				$("#enabled_count").html(parseInt($("#enabled_count").html()) + 1);
			}
		});
	},
	
	disableModule: function(moduleId, element)
	{
		UI.confirm("Are you sure you want to disable " + moduleId + "?", "Yes", function()
		{
			$.post(Config.URL + 'admin/disable/' + moduleId, {csrf_token_name: Config.CSRF}, function(data)
			{
				if(data == 'SUCCESS')
				{
					$(element).attr("onClick", "Admin.enableModule(" + moduleId + ", this)").html("Enable");
					
					var parent = $(element).parent();

					$("#disabled_modules").append(parent[0]);
					$("#enabled_count").html(parseInt($("#enabled_count").html()) - 1);
					$("#disabled_count").html(parseInt($("#disabled_count").html()) + 1);
				}
				else
				{
					UI.alert(moduleId + " is a core module that can not be disabled!");
				}
			});
		});
	},

	currentHeader: false,

	changeHeader: function(current, blank, theme)
	{
		if(this.currentHeader)
		{
			current = this.currentHeader;
		}

		var changeHTML = '<a style="display:inline;float:none;color:#1D6D9C;font-weight:normal;margin:0px;padding:0px;width:auto;" target="_blank" href="' + Config.URL + 'application/themes/' + theme + '/' + blank + '">Click here</a> for an empty copy of the header' + 
						'<input type="text" id="theme_header" value="' + current + '" placeholder="http://"/>';

		UI.confirm(changeHTML, "Save", function()
		{
			var values = {
				header_url:$("#theme_header").val(),
				csrf_token_name:Config.CSRF
			};

			Admin.currentHeader = values.header_url;

			$.post(Config.URL + "admin/saveHeader", values);

			if(values.header_url.length > 0)
			{
				$("#header_field").html("Custom");
			}
			else
			{
				$("#header_field").html("Default");
			}
		});
	},

	remoteCheck: function()
	{
		setTimeout(function() {
			$(".shouldHaveAlert").addClass("alert");
		}, 500);

		$.get(Config.URL + "admin/remote", function(data)
		{
			switch(data)
			{
				case '1':
					$("#system_box").addClass("alert");
					$("#update").fadeIn(500);
				break;

				case '2':
					UI.alert('This copy of FusionCMS has been terminated due to illegal usage. If you actually own a legit copy, please contact us at fusion-hub.com', 6000);

					setTimeout(function()
					{
						window.location = Config.URL;
					}, 6000);
				break;
			}
		});
	}
}


$(document).ready(function()
{
	Admin.remoteCheck();
});
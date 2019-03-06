var Settings = {
	
	/**
	 * Removes a realm
	 * @param  Int id
	 * @param  Object element
	 */
	remove: function(id, element)
	{
		if($("#realm_count").html() == "1")
		{
			UI.alert("You must always have at least one realm!");
		}
		else
		{
			UI.confirm("Do you really want to delete this realm?", "Yes", function()
			{
				$("#realm_count").html(parseInt($("#realm_count").html()) - 1);

				$(element).parents("li").slideUp(300, function()
				{
					$(this).remove();
				});

				$.get(Config.URL + "admin/realmmanager/delete/" + id, function(data)
				{
					console.log(data);
				});
			});
		}
	},

	showAddRealm: function()
	{
		if($("#non_realm").is(":visible"))
		{
			$("#non_realm").fadeOut(100, function()
			{
				$('#realm_settings').fadeOut(100, function()
				{
					$('#add_realm').fadeIn(100);
				});
			});
		}
		else
		{
			$('#add_realm').fadeOut(100, function()
			{
				$("#realm_settings").fadeIn(100, function()
				{
					$('#non_realm').fadeIn(100);
				});
			});
		}
	},

	addRealm: function()
	{
		var data = {
			name: $("#realmName").val(),
			hostname: $("#hostname").val(),
			username: $("#username").val(),
			password: $("#password").val(),
			characters: $("#characters").val(),
			world: $("#world").val(),
			cap: $("#cap").val(),
			port: $("#port").val(),
			emulator: $("#emulator").val(),
			console_username: $("#console_username").val(),
			console_password: $("#console_password").val(),
			console_port: $("#console_port").val(),
			csrf_token_name: Config.CSRF
		};

		if($("#server_structure").val() == "2")
		{
			data.override_hostname_char = $("#override_hostname_char").val();
			data.override_username_char = $("#override_username_char").val();
			data.override_password_char = $("#override_password_char").val();
			data.override_port_char = $("#override_port_char").val();
			data.override_hostname_world = $("#override_hostname_char").val();
			data.override_username_world = $("#override_username_char").val();
			data.override_password_world = $("#override_password_char").val();
			data.override_port_world = $("#override_port_char").val();
		}
		else if($("#server_structure").val() == "3")
		{
			data.override_hostname_char = $("#override_hostname_char_three").val();
			data.override_username_char = $("#override_username_char_three").val();
			data.override_password_char = $("#override_password_char_three").val();
			data.override_port_char = $("#override_port_char_three").val();
			data.override_hostname_world = $("#override_hostname_world_three").val();
			data.override_username_world = $("#override_username_world_three").val();
			data.override_password_world = $("#override_password_world_three").val();
			data.override_port_world = $("#override_port_world_three").val();
		}

		var emulatorText = data.emulator.toUpperCase();

		$.post(Config.URL + "admin/realmmanager/create", data, function(id)
		{
			if(/^[0-9]*$/.test(id))
			{
				var realmHTML = '<li>\
								<table width="100%">\
									<tr>\
										<td width="10%">ID: ' + id + '</td>\
										<td width="30%"><b>' + data.name + '</b></td>\
										<td width="30%">' + data.hostname + '</td>\
										<td width="20%">' + emulatorText + '</td>\
										<td style="text-align:right;">\
											<a href="' + id + '" data-tip="Edit"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;\
											<a href="javascript:void(0)" onClick="Settings.remove(' + id + ', this)" data-tip="Delete"><img src="' + Config.URL + 'application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>\
										</td>\
									</tr>\
								</table>\
							</li>';

				$("#realm_count").html(parseInt($("#realm_count").html()) + 1);
				$("#realm_list").append(realmHTML);
				$("#add_realm").fadeOut(100, function()
				{
					$("#realm_settings").fadeIn(100, function()
					{
						$("#non_realm").fadeIn(100);
					});
				});
			}
			else
			{
				UI.alert(id);
			}
		});
	},

	saveRealm: function(id)
	{
		var data = {
			realmName: $("#realmName").val(),
			hostname: $("#hostname").val(),
			username: $("#username").val(),
			password: $("#password").val(),
			characters: $("#characters").val(),
			world: $("#world").val(),
			cap: $("#cap").val(),
			port: $("#port").val(),
			emulator: $("#emulator").val(),
			console_username: $("#console_username").val(),
			console_password: $("#console_password").val(),
			console_port: $("#console_port").val(),
			csrf_token_name: Config.CSRF
		};

		data.override_hostname_char = $("#override_hostname_char").val();
		data.override_username_char = $("#override_username_char").val();
		data.override_password_char = $("#override_password_char").val();
		data.override_port_char = $("#override_port_char").val();
		data.override_hostname_world = $("#override_hostname_world").val();
		data.override_username_world = $("#override_username_world").val();
		data.override_password_world = $("#override_password_world").val();
		data.override_port_world = $("#override_port_world").val();

		$.post(Config.URL + "admin/realmmanager/save/" + id, data, function(result)
		{
			if(result == "success")
			{
				window.location = Config.URL + "admin/settings";
			}
			else
			{
				UI.alert(result);
			}
		});
	},

	toggleVoteReminder: function(object)
	{
		if(object.value == '1')
		{
			$('#vote_reminder_settings').fadeIn(300);
		}
		else
		{
			$('#vote_reminder_settings').fadeOut(300);
		}
	},

	saveWebsiteSettings: function()
	{
		var data = {
			title:$("#title").val(),
			server_name:$("#server_name").val(),
			realmlist:$("#realmlist").val(),
			disabled_expansions:$("#disabled_expansions").val(),
			keywords:$("#keywords").val(),
			description:$("#description").val(),
			analytics:$("#analytics").val(),
			vote_reminder:$("#vote_reminder").val(),
			vote_reminder_image:$("#vote_reminder_image").val(),
			reminder_interval:$("#reminder_interval").val(),
			cdn:$("#cdn").val(),
			has_smtp:$("#has_smtp").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveWebsite", data, function(response)
		{
			if(response == "yes")
			{
				$("#website_ajax").html('Settings have been saved!');
			}
			else
			{
				UI.alert(response);
			}
		});
	},

	saveSmtpSettings: function()
	{
		var data = {
			use_own_smtp_settings:$("#use_own_smtp_settings").val(),
			smtp_host:$("#smtp_host").val(),
			smtp_user:$("#smtp_user").val(),
			smtp_pass:$("#smtp_pass").val(),
			smtp_port:$("#smtp_port").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/saveSmtp", data, function(response)
		{
			if(response == "yes")
			{
				$("#smtp_ajax").html('Settings have been saved!');
			}
			else
			{
				UI.alert(response);
			}
		});
	},

	savePerformanceSettings: function()
	{
		var data = {
			disable_visitor_graph:$("#disable_visitor_graph").val(),
			csrf_token_name: Config.CSRF
		};

		$.post(Config.URL + "admin/settings/savePerformance", data, function(response)
		{
			if(response == "yes")
			{
				$("#performance_ajax").html('Settings have been saved!');
			}
			else
			{
				UI.alert(response);
			}
		});
	},

	submitConfig: function(form, moduleName, configName)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).children("input, select").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + "admin/edit/save/" + moduleName + "/" + configName, values, function(data)
		{
			console.log(data);
			UI.alert(data);
		});
	},

	submitConfigSource: function(moduleName, configName)
	{
		var values = {
			csrf_token_name: Config.CSRF,
			source: $("#source_" + configName).val()
		};

		console.log(values);

		$.post(Config.URL + "admin/edit/saveSource/" + moduleName + "/" + configName, values, function(data)
		{
			UI.alert(data);
		});
	},

	toggleSource: function(id, field)
	{
		if($("#advanced_" + id).is(":visible"))
		{
			$(field).html("Edit source code (advanced)");

			$("#advanced_" + id).fadeOut(150, function()
			{
				$("#gui_" + id).fadeIn(150);
			});
		}
		else
		{
			$(field).html("Edit values (simple)");

			$("#gui_" + id).fadeOut(150, function()
			{
				$("#advanced_" + id).fadeIn(150);
			});
		}
	},

	submitMessage: function(form)
	{
		var values = {csrf_token_name: Config.CSRF};

		$(form).children("input, select, textarea").each(function()
		{
			if($(this).attr("type") != "submit")
			{
				values[$(this).attr("name")] = $(this).val();
			}
		});

		$.post(Config.URL + "admin/message/save", values, function(data)
		{
			console.log(data);
			UI.alert(data);
		});
	},

	liveUpdate: function(element, type)
	{
		if(type == "headline_size")
		{
			$("#live_headline").css("font-size", element.value + "px");
		}
		else
		{
			$("#live_" + type).html(element.value);
		}
	},

	changeStructure: function(element)
	{
		switch(element.value)
		{
			case "1":
				$("#two, #three").hide();
				$("#one").show();
			break;

			case "2":
				$("#one, #three").hide();
				$("#two").show();
			break;

			case "3":
				$("#two, #one").hide();
				$("#three").show();
			break;
		}
	}
}
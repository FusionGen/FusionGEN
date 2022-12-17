var Auth = {
	timeout: null,
	usernameTimeout: null,
	passwordTimeout: null,
	useCaptcha: false,
	
	old: {
		"username": "",
		"password": "",
		"captcha": ""
	},
	
	login: function(submit = false) {
		var postData = {
			"username": $(".username-input").val(),
			"password": $(".password-input").val(),
			"remember": $(".remember-check").is(":checked"),
			"captcha": $(".captcha-input").val(),
			"submit": submit,
			"csrf_token_name": Config.CSRF
		};
		
		var fields = [
			"username", "password"
		];

		if(Auth.useCaptcha) {
			fields.push("captcha");
		}

		console.log("fields", fields);
		
		clearTimeout (Auth.timeout);
		Auth.timeout = setTimeout (function() {
			
			$(".card-login-avatar .loading").fadeIn(200); //Show Loading
			//$("button.card-footer").attr("disabled", true); //Disable Button
			
			//Change icon/image if different username
			if(Auth.old["username"] != $(".username-input").val()) {
				$(".fa-user-lock").show(); //Show User Lock Icon
				$(".user-avatar").hide(); //Hide User Avatar
			}
			
			for(var i = 0; i<fields.length;i++) {
				if(Auth.old[fields[i]] != $("."+ fields[i] +"-input").val() || postData["username"] == "") {
					$("."+ fields[i] +"-input").parents(".input-group").removeClass("border border-danger border-success"); 
					$("."+ fields[i] +"-input").removeClass("is-valid is-invalid"); 
					$("."+ fields[i] +"-feedback").removeClass("valid-feedback invalid-feedback d-block").addClass("d-none");
				}
			}
			
			if(postData["username"] == "") {
				$(".card-login-avatar .loading").fadeOut(500);
				return;
			}

			if($(".password-input").val().length >= 6)
			{
				$.post(Config.URL + "auth/checkLogin", postData, function(data) {
					$(".card-login-avatar .loading").fadeOut(500);
					try {
						data = JSON.parse(data);
						console.log(data);
						
						if(data["type"] === "login") {
							if(data["redirect"] === true) {
								window.location.href = Config.URL + "ucp";
								return;
							}
	
							if(data["showCaptcha"] === true) {
								$(".captcha-field").removeClass("d-none");
							}
							
							if(data["exists"] === true) {
								$(".username-input").parents(".input-group").addClass("border border-success");
								$(".username-input").addClass("border-0 is-valid");
								$(".user-avatar").attr("src", data["avatar"]);
								setTimeout(function() {
									$(".fa-user-lock").hide();
									$(".user-avatar").show();
								}, 200);
							}
							
							for(var i = 0; i<fields.length;i++) {
								if(fields[i] == "password" && postData["submit"] != true) continue;
								if(data["messages"][fields[i]] != "") {
									if($("."+ fields[i] +"-input").val() != "") { //Check if doesnt empty
										$("."+ fields[i] +"-input").parents(".input-group").addClass("border border-danger");
										$("."+ fields[i] +"-input").addClass("is-invalid");
										$("."+ fields[i] +"-feedback").addClass("invalid-feedback d-block").removeClass("d-none").html(data["messages"][fields[i]]);
									}
								} else {
									if(data["messages"]["username"] == "") {
										if(Auth.old[fields[i]] != $("."+ fields[i] +"-input").val()) {
											$("."+ fields[i] +"-input").parents(".input-group").addClass("border border-success");
											$("."+ fields[i] +"-input").addClass("is-valid");
										}
									}
								}
								
								Auth.old[fields[i]] = $("."+ fields[i] +"-input").val(); //Set old values
							}
						}
					} catch(e) {
						console.error(e);
						console.log(data);
					}				
				});
			}
			
			console.log(postData);

		}, 500);
	},
	
	showPassword: function(ele) {
		if($(ele).data("show") == true) {
			$(ele).html('<i class="fas fa-eye-slash"></i>');
			$(ele).data("show", false);
			
			$("input#"+ $(ele).data("input-id")).attr("type", "password");
		} else if($(ele).data("show") == false) {
			$(ele).html('<i class="fas fa-eye"></i>');
			$(ele).data("show", true);
			
			$("input#"+ $(ele).data("input-id")).attr("type", "text");
		}
		
	},

	refreshCaptcha: function(ele) {
		var captchaID = $(ele).data("captcha-id");
		var imgField = $("img#"+ captchaID);
		imgField.attr("src", imgField.attr("src") +"&d="+ new Date().getTime());
	}
};
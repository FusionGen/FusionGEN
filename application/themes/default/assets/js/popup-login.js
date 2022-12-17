var Popup = {
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
			"username": $(".username-input2").val(),
			"password": $(".password-input2").val(),
			"remember": $(".remember-check2").is(":checked"),
			"captcha": $(".captcha-input2").val(),
			"submit": submit,
			"csrf_token_name": Config.CSRF
		};
		
		var fields = [
			"username", "password"
		];

		if(Popup.useCaptcha) {
			fields.push("captcha");
		}

		console.log("fields", fields);
		
		clearTimeout (Popup.timeout);
		Popup.timeout = setTimeout (function() {
			
			for(var i = 0; i<fields.length;i++) {
				if(Popup.old[fields[i]] != $("."+ fields[i] +"-input2").val() || postData["username"] == "") {
					$("."+ fields[i] +"-input2").parents(".input-group").removeClass("border border-danger border-success"); 
					$("."+ fields[i] +"-input2").removeClass("is-valid is-invalid"); 
					$("."+ fields[i] +"-feedback2").removeClass("valid-feedback invalid-feedback d-block").addClass("d-none");
				}
			}

			if($(".password-input2").val().length >= 6)
			{
				$.post(Config.URL + "auth/checkLogin", postData, function(data) {
					try {
						data = JSON.parse(data);
						console.log(data);
						
						if(data["type"] === "login") {
							if(data["redirect"] === true) {
								window.location.href = Config.URL + "ucp";
								return;
							}
	
							if(data["showCaptcha"] === true) {
								$(".captcha-field2").removeClass("d-none");
							}
							
							if(data["exists"] === true) {
								$(".username-input2").parents(".input-group").addClass("border border-success");
								$(".username-input2").addClass("border-0 is-valid");
							}
							
							for(var i = 0; i<fields.length;i++) {
								if(fields[i] == "password" && postData["submit"] != true) continue;
								if(data["messages"][fields[i]] != "") {
									if($("."+ fields[i] +"-input2").val() != "") { //Check if doesnt empty
										$("."+ fields[i] +"-input2").parents(".input-group").addClass("border border-danger");
										$("."+ fields[i] +"-input2").addClass("is-invalid");
										$("."+ fields[i] +"-feedback2").addClass("invalid-feedback d-block").removeClass("d-none").html(data["messages"][fields[i]]);
									}
								} else {
									if(data["messages"]["username"] == "") {
										if(Popup.old[fields[i]] != $("."+ fields[i] +"-input2").val()) {
											$("."+ fields[i] +"-input2").parents(".input-group").addClass("border border-success");
											$("."+ fields[i] +"-input2").addClass("is-valid");
										}
									}
								}
								
								Popup.old[fields[i]] = $("."+ fields[i] +"-input2").val(); //Set old values
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
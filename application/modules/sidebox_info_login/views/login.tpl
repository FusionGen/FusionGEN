<form onKeyUp="Auth.login(); return false;" onSubmit="Auth.login(true); return false;">
	<div class="input-group p-0 flex-row">
		<label for="floatingUser" class="input-group-text" id="username" style="width:40px;"><i class="fas fa-user"></i></label>
		<input type="text" class="form-control username-input border-0" id="floatingUser" placeholder="{lang('login_label_user', 'sidebox_info_login')}" aria-describedby="username">
	</div>
	
	<div class="input-group mt-3">
		<label class="input-group-text cursor-pointer" id="password" style="width:40px;" data-input-id="floatingPassword" data-show="false" onClick="Auth.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
		<input type="password" class="form-control password-input border-0" id="floatingPassword" placeholder="{lang('login_label_password', 'sidebox_info_login')}" aria-describedby="password">
	</div>
	
	<div class="card-links mt-3 d-flex justify-content-between">
		<div class="form-check form-switch">
			<input class="form-check-input remember-check" type="checkbox" id="checkRemember">
			<label class="form-check-label" for="checkRemember">{lang("login_label_remember", "sidebox_info_login")}</label>
		</div>
		
		<a href="{$url}password_recovery" class="card-link">{lang("login_link_password_forgot", "sidebox_info_login")}</a>
	</div>
		
	<div class="form-group text-center mt-4">
	<button class="card-footer nice_button">
		{lang("login_button", "sidebox_info_login")}
	</button>
	</div>
</form>

<script>
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
			
			//Change icon/image if different username
			if(Auth.old["username"] != $(".username-input").val()) {
				$(".fa-user-lock").show(); //Show User Lock Icon
			}
			
			for(var i = 0; i<fields.length;i++) {
				if(Auth.old[fields[i]] != $("."+ fields[i] +"-input").val() || postData["username"] == "") {
					$("."+ fields[i] +"-input").parents(".input-group").removeClass("border border-danger border-success"); 
					$("."+ fields[i] +"-input").removeClass("is-valid is-invalid"); 
					$("."+ fields[i] +"-feedback").removeClass("valid-feedback invalid-feedback d-block").addClass("d-none");
				}
			}
			
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
							$(".captcha-field").removeClass("d-none");
						}
						
						if(data["exists"] === true) {
							$(".username-input").parents(".input-group").addClass("border border-success");
							setTimeout(function() {
								$(".fa-user-lock").hide();
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
</script>
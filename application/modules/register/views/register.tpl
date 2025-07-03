<div class="page-subbody mt-0">
	<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
		<div class="card-body">
			{form_open('register', 'id="register_form" onSubmit="Validate.submit(); return false"')}
			<div class="input-group p-0 flex-row mb-3">
			<label for="register_username" class="input-group-text" style="width:45px;"><i class="fas fa-user"></i></label>
				<input class="form-control" type="text" name="register_username" id="register_username" placeholder="{lang('username', 'register')}" autocomplete="username" value="{set_value('register_username')}" onchange="Validate.checkUsername()" required>
			</div>

			<div class="input-group p-0 flex-row mb-3">
			<label for="register_email" class="input-group-text" style="width:45px;"><i class="fas fa-envelope"></i></label>
				<input class="form-control" type="email" name="register_email" id="register_email" placeholder="{lang('email', 'register')}" value="{set_value('register_email')}" onchange="Validate.checkEmail()" required>
			</div>

			<div class="input-group p-0 flex-row mb-3">
			<label for="register_password" class="input-group-text" style="width:45px; cursor:pointer;" data-input-id="register_password" data-show="false" onClick="Validate.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
				<input class="form-control" type="password" name="register_password" id="register_password" placeholder="{lang('password', 'register')}" autocomplete="new-password" value="{set_value('register_password')}" onchange="Validate.checkPassword()" required>
			</div>

			<div class="input-group p-0 flex-row mb-3">
			<label for="register_password_confirm" class="input-group-text" style="width:45px; cursor:pointer;" data-input-id="register_password_confirm" data-show="false" onClick="Validate.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
				<input class="form-control" type="password" name="register_password_confirm" placeholder="{lang('confirm', 'register')}" autocomplete="new-password" id="register_password_confirm" value="{set_value('register_password_confirm')}" onchange="Validate.checkPasswordConfirm()" required>
			</div>

			{if $use_captcha && $captcha_type == 'inbuilt'}
			<div class="input-group mt-3">
				<label for="register_captcha" class="input-group-text w-100 text-center d-block">
					<img src="{$url}register/getCaptcha?{time()}" class="img-fluid pe-none user-select-none" alt="captcha" id="captchaImage">
				</label>

				<div class="input-group p-0 flex-row ms-0 flex-grow-1">
				<label for="register_captcha" class="input-group-text cursor-pointer" id="captcha" style="width:45px; cursor:pointer;" data-captcha-id="captchaImage" onclick="Validate.refreshCaptcha(this);"><i class="fas fa-rotate"></i></label>
					<input type="text" class="form-control captcha-input border-0" name="register_captcha" id="register_captcha" placeholder="CAPTCHA" aria-describedby="captcha" required>
				</div>
			</div>
			{/if}

			<div class="form-group text-center mt-4">
				<button class="nice_button rounded" type="submit" name="login_submit">{lang("submit", "register")}</button>
			</div>
			{form_close()}
		</div>
	</div>
</div>

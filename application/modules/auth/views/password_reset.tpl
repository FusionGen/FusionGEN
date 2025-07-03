<div class="page-subbody">
	<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
		<div class="card-body">
			<form onSubmit="Recovery.reset(); return false">
				<div class="alert text-center error-feedback d-none" role="alert"></div>

				<div class="input-group p-0 flex-row">
					<label for="token" class="input-group-text" style="width:45px;"><i class="fas fa-key"></i></label>
					<input type="text" id="token" value="{$token}" class="form-control token-input border-0" placeholder="{lang('token', 'recovery')}" disabled required>
				</div>

				<div class="input-group p-0 flex-row mt-3 mb-4">
					<label for="password" class="input-group-text" style="width:45px; cursor:pointer;" data-input-id="password" data-show="false" onClick="Recovery.showPassword(this);"><i class="fas fa-eye-slash"></i></label>
					<input type="password" id="password" class="form-control password-input border-0" placeholder="{lang('new_password', 'recovery')}" required>
				</div>

				<input type="submit" value="{lang('password_reset', 'recovery')}" class="nice_button rounded">
			</form>
		</div>
	</div>
</div>

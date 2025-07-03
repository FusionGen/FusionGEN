<div class="page-subbody">
	<div class="col-12 col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 mx-auto">
		<div class="card-body">
			<h4 class="text-uppercase mb-3">{lang("lost_password", "recovery")}</h4>
			<p>{lang("enter_your_email", "recovery")}</p>
			<form onSubmit="Recovery.request(); return false">
				<div class="alert text-center error-feedback d-none" role="alert"></div>

				<div class="input-group p-0 flex-row mb-4">
					<label for="email" class="input-group-text" style="width:45px;"><i class="fas fa-envelope"></i></label>
					<input type="email" id="email" class="form-control email-input border-0" autocomplete="email" placeholder="{lang('email', 'recovery')}" required>
				</div>

				<input type="submit" value="{lang('recover', 'recovery')}" class="nice_button rounded">
			</form>
		</div>
	</div>
</div>

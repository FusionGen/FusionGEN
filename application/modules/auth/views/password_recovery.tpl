<div class="page-subbody">
	<div class="page_form">
		<h4 class="text-uppercase mb-3">{lang("lost_password", "recovery")}</h4>
		<p>{lang("enter_your_email", "recovery")}</p>
		<form onSubmit="Recovery.request(); return false">
			<div class="alert text-center error-feedback d-none" role="alert"></div>

			<label>{lang("email", "recovery")}</label>
			<input type="email" class="email-input mb-3" required>

			<input type="submit" value="{lang('recover', 'recovery')}" class="nice_button rounded">
		</form>
	</div>
</div>

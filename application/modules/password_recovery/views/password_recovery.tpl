<div class="row justify-content-md-center">
	<div class="col-md-6">
		<div class="featured-box featured-box-primary text-start mt-0">
			<div class="box-content">
				<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-0">{lang('lost_password', 'recovery')}</h4>
				<p class="text-2 opacity-7">{lang('enter_your_username', 'recovery')}</p>
				<form onSubmit="Recovery.get(this); return false" class="needs-validation">
					<div class="row">
						<div class="form-group col">
							<label class="form-label">{lang('username', 'recovery')}</label>
							<input type="text" name="recovery" id="recovery" value="" class="form-control form-control-lg" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<input type="submit" value="{lang('recover', 'recovery')}" class="btn btn-primary btn-modern float-end">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
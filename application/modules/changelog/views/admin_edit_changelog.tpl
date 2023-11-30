<div class="box big">
	<div class="card-header">Edit change</div>
	<div class="card-body">
	<form onSubmit="Changelog.save(this, {$changelog.change_id}); return false" id="submit_form">
	<div class="form-group row mb-3">
	<label class="col-sm-2 col-form-label" for="text">Message</label>
	<div class="col-sm-10">
		<textarea class="form-control" id="text" name="text" rows="4">{$changelog.changelog}</textarea>
	</div>
	</div>
	<input class="btn btn-primary btn-sm" type="submit" value="Save change">
	</form>
	</div>
</div>

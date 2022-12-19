<div class="card">
	<div class="card-header">New slide</div>
	<div class="card-body">
	<form onSubmit="Slider.create(this); return false">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="image">Image URL</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="image" id="image" placeholder="http://"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_header">Text Header (optional)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="text_header" id="text_header"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_body">Text Body (optional)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="text_body" id="text_body"/>
			</div>
		</div>

		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="text_footer">Text Footer (optional)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="text_footer" id="text_footer"/>
			</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit slider</button>
	</form>
	</div>
</div>
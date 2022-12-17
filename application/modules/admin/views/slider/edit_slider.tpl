<div class="card">
	<div class="card-header">Edit slide</div>
	<div class="card-body">

	<form onSubmit="Slider.save(this, {$slide.id}); return false" id="submit_form">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="image">Image URL</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="image" id="image" placeholder="http://" value="{preg_replace('/{path}/', '', $slide.image)}"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="text_header">Text Header (optional)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="text_header" id="text_header" value="{$slide.header}"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="text_body">Text Body (optional)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="text_body" id="text_body" value="{$slide.body}"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="text_footer">Text Footer (optional)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="text_footer" id="text_footer" value="{$slide.footer}"/>
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Save slide</button>
	</form>
	</div>
</div>
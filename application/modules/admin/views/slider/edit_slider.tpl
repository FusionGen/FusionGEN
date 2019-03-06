<section class="box big">
	<h2>Edit slide</h2>

	<form onSubmit="Slider.save(this, {$slide.id}); return false" id="submit_form">
		<label for="image">Image URL</label>
		<input type="text" name="image" id="image" placeholder="http://" value="{preg_replace('/{path}/', '', $slide.image)}"/>

		<label for="link">Link (optional)</label>
		<input type="text" name="link" id="link" placeholder="http://"value="{$slide.link}"/>

		<label for="text">Image text (optional)</label>
		<input type="text" name="text" id="text"value="{$slide.text}"/>

		<input type="submit" value="Save slide" />
	</form>
</section>
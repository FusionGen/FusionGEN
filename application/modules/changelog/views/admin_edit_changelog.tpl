<section class="box big">
	<h2>Edit change</h2>

	<form onSubmit="Changelog.save(this, {$changelog.change_id}); return false" id="submit_form">
		
		<label for="text">Message</label>
		<textarea id="text" name="text" rows="4">{$changelog.changelog}</textarea>
	
		<input type="submit" value="Save change" />
	</form>
</section>
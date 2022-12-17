{TinyMCE()}
<div class="card">
  <header class="card-header">
	Edit Sidebox <a class="btn btn-primary btn-sm pull-right" href="{$url}admin/sidebox">Back</a>
  </header>
  <div class="card-body">
	<form role="form" onSubmit="Sidebox.save(this, {$sidebox.id}); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="displayName">Headline</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="displayName" id="displayName" value="{htmlspecialchars($sidebox.displayName)}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="type">Sidebox module</label>
		<div class="col-sm-10">
		<select class="form-control" id="type" name="type" onChange="Sidebox.toggleCustom(this)">
			{foreach from=$sideboxModules item=module key=name}
				<option value="{$name}">{$module.name}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
		<div class="col-sm-10">
		<select class="form-control" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" selected>Visible to everyone</option>
			<option value="group">Controlled per group</option>
		</select>
		</div>
		<div style="display:none" id="groups">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the sidebox
		</div>
		</div>
	</form>

	<div id="custom_field" style="padding-top:0px;padding-bottom:0px;{if $sidebox.type != "custom"}display:none{/if}" >
		<textarea name="content" class="form-control tinymce mb-3" id="content" cols="30" rows="10">{$sideboxCustomText}</textarea>
	</div>

	<form role="form" onSubmit="Sidebox.save(document.getElementById('submit_form'), {$sidebox.id}); return false">
		<button type="submit" class="btn btn-primary btn-sm">Save sidebox</button>
	</form>
</div>
</div>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#displayName"));
	});
</script>
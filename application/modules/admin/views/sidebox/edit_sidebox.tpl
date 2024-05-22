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
			<input class="form-control" type="text" name="displayName" id="displayName" value="{htmlspecialchars($sidebox.displayName)}">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="type">Sidebox module</label>
		<div class="col-sm-10">
		<select class="form-control" id="type" name="type" onChange="Sidebox.toggleCustom(this)">
			{foreach from=$sideboxModules item=module key=name}
				<option value="{$name}" {if $sidebox.type == preg_replace("/sidebox_/", "", $name)}selected{/if}>{$module.name}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
		<div class="col-sm-10">
		<select class="form-control" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').removeClass('d-none'); } else { $('#groups').addClass('d-none'); }">
			<option value="everyone" {if !$sidebox.permission}selected{/if}>Visible to everyone</option>
			<option value="group" {if $sidebox.permission}selected{/if}>Controlled per group</option>
		</select>
		</div>
		</div>

		<div id="groups" class="form-group row {if !$sidebox.permission}d-none{/if}">
			<span>Please manage the group visibility via <a target="_blank" href="{$url}admin/aclmanager/groups">the group manager</a> once you edited the sidebox.</span>
		</div>

	</form>

	<div id="custom_field" class="p-0 mt-3 {if $sidebox.type != "custom"}d-none{/if}">
		<textarea name="content" class="form-control tinymce mb-3" id="content" cols="30" rows="10">{$sideboxCustomText}</textarea>
	</div>

	<form class="mt-3" role="form" onSubmit="Sidebox.save(document.getElementById('submit_form'), {$sidebox.id}); return false">
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

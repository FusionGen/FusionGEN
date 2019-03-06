<section class="box big">
	<h2>Edit sidebox</h2>

	<form onSubmit="Sidebox.save(this, {$sidebox.id}); return false" id="submit_form">
		<label for="displayName">Headline</label>
		<input type="text" name="displayName" id="displayName" value="{htmlspecialchars($sidebox.displayName)}"/>

		<label for="type">Sidebox module</label>
		<select id="type" name="type" onChange="Sidebox.toggleCustom(this)">
			{foreach from=$sideboxModules item=module key=name}
				<option value="{$name}" {if $sidebox.type == preg_replace("/sidebox_/", "", $name)}selected{/if}>{$module.name}</option>
			{/foreach}
		</select>

		<label for="visibility">Visibility mode</label>
		<select name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" {if !$sidebox.permission}selected{/if}>Visible to everyone</option>
			<option value="group" {if $sidebox.permission}selected{/if}>Controlled per group</option>
		</select>

		<div {if !$sidebox.permission}style="display:none"{/if} id="groups">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a>
		</div>
	</form>

	<span id="custom_field" style="padding-top:0px;padding-bottom:0px;{if $sidebox.type != "custom"}display:none{/if}" >
		<label for="text">Content</label>
		{$fusionEditor}
	</span>

	<form onSubmit="Sidebox.save(document.getElementById('submit_form'), {$sidebox.id}); return false">
		<input type="submit" value="Save sidebox" />
	</form>
</section>

<script>
	require([Config.URL + "application/themes/admin/js/mli.js"], function()
	{
		new MultiLanguageInput($("#displayName"));
	});
</script>
{TinyMCE()}
<div class="card">
  <div class="card-header">
    Edit Page → {langColumn($page['name'])}<a class="btn btn-primary btn-sm pull-right" href="{$url}page/admin">Back</a>
  </div>

	<div class="card-body">
	<form id="pages" onSubmit="Pages.send({$page.id}); return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="headline">Headline</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" id="headline" name="headline" value="{htmlspecialchars($page.name)}" required />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="identifier">Unique link identifier (as in mywebsite.com/page/<b>mypage</b>)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" id="identifier" name="identifier" placeholder="mypage" value="{$page.identifier}" required />
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
		<div class="col-sm-10">
		<select class="form-control" name="visibility" id="visibility" name="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" {if !$page.permission}selected{/if}>Visible to everyone</option>
			<option value="group" {if $page.permission}selected{/if}>Controlled per group</option>
		</select>

		<div {if !$page.permission}style="display:none"{/if} id="groups">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a>
		</div>
		</div>
		</div>
		</form>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="pages_content">Content</label>
		<div class="col-sm-10">
			<textarea name="pages_content" class="form-control tinymce" id="pages_content">{$page.content}</textarea>
		</div>
		</div>

		<form onSubmit="Pages.send({$page.id}); return false">
		<button type="submit" class="btn btn-primary btn-sm">Submit page</button>
		</form>
	</div>
</div>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#headline"));
	});
</script>
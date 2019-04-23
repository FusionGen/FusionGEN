{TinyMCE()}
<section class="box big">
	<h2>Edit page</h2>

	<form onSubmit="Pages.send({$page.id}); return false">
		<label for="headline">Headline</label>
		<input type="text" id="headline" value="{htmlspecialchars($page.name)}"/>
		
		<label for="identifier">Unique link identifier (as in mywebsite.com/page/<b>mypage</b>)</label>
		<input type="text" id="identifier" placeholder="mypage" value="{$page.identifier}" />

		<label for="visibility">Visibility mode</label>
		<select name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" {if !$page.permission}selected{/if}>Visible to everyone</option>
			<option value="group" {if $page.permission}selected{/if}>Controlled per group</option>
		</select>

		<div {if !$page.permission}style="display:none"{/if} id="groups">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a>
		</div>

		<label for="pages_content">
			Content
		</label>
	</form>
		<div style="padding:10px;">
			<textarea name="pages_content" class="tinymce" id="pages_content" cols="30" rows="10">{$page.content}</textarea>
		</div>
	<form onSubmit="Pages.send({$page.id}); return false">
		<input type="submit" value="Save page" />
	</form>
</section>

<script>
	require([Config.URL + "application/themes/admin/js/mli.js"], function()
	{
		new MultiLanguageInput($("#headline"));
	});
</script>
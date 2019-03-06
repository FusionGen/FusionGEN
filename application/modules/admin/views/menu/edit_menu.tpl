<section class="box big">
	<h2>Edit link</h2>

	<form onSubmit="Menu.save(this, {$link.id}); return false" id="submit_form">
		<label for="name">Title</label>
		<input type="text" name="name" id="name" placeholder="My link" value="{htmlspecialchars($link.name)}" />

		<label for="type" data-tip="External links must begin with http://">URL <a>(?)</a></label>
		<input type="text" name="link" id="link" placeholder="http://" value="{$link.link}"/>

		<label for="side">Menu location</label>
		<select name="side" id="side">
			<option value="top" {if $link.side == "top"}selected{/if}>Top</option>
			<option value="side" {if $link.side == "side"}selected{/if}>Side</option>
		</select>

		<label for="visibility">Visibility mode</label>
		<select name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" {if !$link.permission}selected{/if}>Visible to everyone</option>
			<option value="group" {if $link.permission}selected{/if}>Controlled per group</option>
		</select>

		<div {if !$link.permission}style="display:none"{/if} id="groups">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a>
		</div>
		
		<label for="direct_link" data-tip="If you want to link to a non-FusionCMS page on the same domain, you must select 'Yes' otherwise FusionCMS will try to load it 'inside' the theme.">Internal direct link <a>(?)</a></label>
		<select name="direct_link" id="direct_link">
				<option value="0" {if $link.direct_link == "0"}selected{/if}>No</option>
				<option value="1" {if $link.direct_link == "1"}selected{/if}>Yes</option>
		</select>

		<input type="submit" value="Save link" />
	</form>
</section>

<script>
	require([Config.URL + "application/themes/admin/js/mli.js"], function()
	{
		new MultiLanguageInput($("#name"));
	});
</script>
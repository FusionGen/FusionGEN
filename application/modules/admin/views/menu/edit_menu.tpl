<section class="card">
	<div class="card-header">Edit link</div>
	
<div class="card-body">
	<form role="form" onSubmit="Menu.save(this, {$link.id}); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name" id="languages">Title</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" placeholder="My link" value="{htmlspecialchars($link.name)}">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="type" data-toggle="tooltip" data-placement="bottom" title="External links must begin with http://">URL <a>(?)</a></label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="link" id="link" placeholder="http://" value="{$link.link}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="side">Menu location</label>
		<div class="col-sm-10">
		<select class="form-control" name="side" id="side">
			<option value="top" {if $link.side == "top"}selected{/if}>Top</option>
			<option value="side" {if $link.side == "side"}selected{/if}>Side</option>
			<option value="bottom" {if $link.side == "bottom"}selected{/if}>Bottom</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="lrd">LRD <a data-toggle="tooltip" data-placement="bottom" title="Left, Right or Dropdown?">(?)</a></label>
		<div class="col-sm-10">
		<select class="form-control" name="lrd" id="lrd">
			<option value="L" {if $link.lrd == "L"}selected{/if}>Left</option>
			<option value="R" {if $link.lrd == "R"}selected{/if}>Right</option>
			<option value="D" {if $link.lrd == "D"}selected{/if}>Dropdown</option>
		</select>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="dropdown_id">Dropdown  <a data-toggle="tooltip" data-placement="bottom" title="The Name from the dropdown">(?)</a></label>
		<div class="col-sm-10">
		<select class="form-control" name="dropdown_id" id="dropdown_id">
			<option value="0">-</option>
			{foreach from=$links item=menu}
				{if $menu.lrd == "D"}<option {if $menu.id == $link.dropdown_id}selected{/if} value="{$menu.id}">{langColumn($menu.name)}</option>{/if}
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="visibility">Visibility mode</label>
		<div class="col-sm-10">
		<select class="form-control" name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" selected>Visible to everyone</option>
			<option value="group">Controlled per group</option>
		</select>
		</div>
		</div>

		<div style="display:none" id="groups">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the sidebox
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Save</button>
	</form>
</div>
</section>

<script>
	require([Config.URL + "application/themes/admin/assets/js/mli.js"], function()
	{
		new MultiLanguageInput($("#name"));
	});
</script>
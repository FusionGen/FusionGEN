<div class="card">
	<div class="card-header"><a href='{$url}store/admin_items' data-bs-toggle="tooltip" data-placement="top" title="Return to items">Items</a> &rarr; New item</div>
	<div class="card-body">
	
	<form>
	<div class="form-group row mb-3">
	<label class="col-sm-2 col-form-label" for="item_type">Item type</label>
	<div class="col-sm-10">
		<select class="form-control" id="item_type" name="item_type" onChange="Items.changeType(this)">
			<option value="item" selected>Item</option>
			<option value="command">Console command</option>
			<option value="query">Query</option>
		</select>
	</div>
	</div>
	</form>

	<form onSubmit="Items.create(this); return false" id="command_form" style="display:none;">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (very short; displayed below item name)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="quality">Item quality</label>
		<div class="col-sm-10">
		<select class="form-control" id="quality" name="quality">
			<option value="0" class="q0">Poor</option>
			<option value="1" class="q1">Common</option>
			<option value="2" class="q2">Uncommon</option>
			<option value="3" class="q3">Rare</option>
			<option value="4" class="q4">Epic</option>
			<option value="5" class="q5">Legendary</option>
			<option value="6" class="q6">Artifact</option>
			<option value="7" class="q7">Heirloom</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label">Need character</label>
		<div class="col-sm-10 align-self-center">
		<div class="checkbox-custom checkbox-default">
			<input type="checkbox" id="command_need_character" name="command_need_character" checked="yes" value="1"/>
		<label for="command_need_character" class="inline_label">Make the user select a character</label>
		</div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label">Require offline</label>
		<div class="col-sm-10 align-self-center">
		<div class="checkbox-custom checkbox-default">
			<input type="checkbox" id="require_character_offline" name="require_character_offline" value="1"/>
		<label for="require_character_offline" class="inline_label">Make sure the selected character is offline</label>
		</div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="command">Command</label>
		<div class="col-sm-10">
		<textarea class="form-control" id="command" name="command"></textarea>
		<span class="help-block">
			{literal}
				<b>{ACCOUNT}</b> = Account Name, 
				<b>{CHARACTER}</b> = Character Name
			{/literal}
		</span>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control" name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}">{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="group">Item group</label>
		<div class="col-sm-10">
		<select class="form-control" name="group" id="group">
			<option value="0">None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}">{$group.title}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="vp_price form-group row">
		<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="vpCost" id="vpCost" value="0"/>
		</div>
		</div>

		<div class="dp_price form-group row">
		<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="dpCost" id="dpCost" value="0"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="icon">Icon name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="icon" id="icon" value="" />
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit command</button>
	</form>

	<form onSubmit="Items.create(this); return false" id="query_form" style="display:none;">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (very short; displayed below item name)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="quality">Item quality</label>
		<div class="col-sm-10">
		<select class="form-control" id="quality" name="quality">
			<option value="0" class="q0">Poor</option>
			<option value="1" class="q1">Common</option>
			<option value="2" class="q2">Uncommon</option>
			<option value="3" class="q3">Rare</option>
			<option value="4" class="q4">Epic</option>
			<option value="5" class="q5">Legendary</option>
			<option value="6" class="q6">Artifact</option>
			<option value="7" class="q7">Heirloom</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="query_database">Database</label>
		<div class="col-sm-10">
		<select class="form-control" id="query_database" name="query_database">
			<option value="cms">CMS</option>
			<option value="realm">Realm (characters)</option>
			<option value="realmd">Realmd (accounts/auth/logon)</option>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label">Need character</label>
		<div class="col-sm-10 align-self-center">
		<div class="checkbox-custom checkbox-default">
			<input type="checkbox" id="query_need_character" name="query_need_character" checked="yes" value="1"/>
		<label for="query_need_character" class="inline_label">Make the user select a character</label>
		</div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label">Require offline</label>
		<div class="col-sm-10 align-self-center">
		<div class="checkbox-custom checkbox-default">
			<input type="checkbox" id="require_character_offline" name="require_character_offline" value="1"/>
		<label for="require_character_offline" class="inline_label">Make sure the selected character is offline</label>
		</div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="query" data-bs-toggle="tooltip" data-placement="top" title="Example query: UPDATE characters SET level = 80 WHERE guid = {literal}{CHARACTER}{/literal}">SQL query <a>(?)</a></label>
		<div class="col-sm-10">
		<textarea class="form-control" id="query" name="query"></textarea>
		<span class="help-block">
			{literal}
				<b>{ACCOUNT}</b> = Account ID, 
				<b>{CHARACTER}</b> = Character ID, 
				<b>{REALM}</b> = Realm ID
			{/literal}
		</span>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control" name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}">{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="group">Item group</label>
		<div class="col-sm-10">
		<select class="form-control" name="group" id="group">
			<option value="0">None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}">{$group.title}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="vp_price form-group row">
		<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="vpCost" id="vpCost" value="0">
		</div>
		</div>

		<div class="dp_price form-group row">
		<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="dpCost" id="dpCost" value="0">
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="icon">Icon name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="icon" id="icon" value="">
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit query</button>
	</form>

	<form onSubmit="Items.create(this); return false" id="item_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Name (only required for multiple items)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" placeholder="Will be added automatically if you only specify one item ID" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="itemid">Item ID (tip: separate ids with , (comma) to add multiple as one)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="itemid" id="itemid" placeholder="12345" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (very short; displayed below item name)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description" placeholder="For example, 'Head (Plate)'" />
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control" name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}">{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="group">Item group</label>
		<div class="col-sm-10">
		<select class="form-control" name="group" id="group">
			<option value="0">None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}">{$group.title}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="vp_price form-group row">
		<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="vpCost" id="vpCost" value="0"/>
		</div>
		</div>

		<div class="dp_price form-group row">
		<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="dpCost" id="dpCost" value="0"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="icon">Icon name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="icon" id="icon" placeholder="Will be added automatically if you leave empty, and only specify one item ID" />
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit item</button>
	</form>
	</div>
</div>
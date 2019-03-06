<section class="box big">
	<h2>Edit item</h2>

	<form>
		<label for="item_type">Item type</label>
		<select id="item_type" name="item_type" onChange="Items.changeType(this)">
			<option value="item" {if !$item.query && !$item.command}selected{/if}>Item</option>
			<option value="command" {if !$item.query && $item.command}selected{/if}>Console command</option>
			<option value="query" {if !$item.command && $item.query}selected{/if}>Query</option>
		</select>
	</form>

	<script type="text/javascript">
		var formType = {if $item.query}"query"{else if $item.command}"command"{else}"item"{/if};
	</script>
	
	<form onSubmit="Items.save(this, {$item.id}); return false" id="command_form" {if !$item.command}style="display:none;"{/if}>

		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="{$item.name}" />

		<label for="description">Description (very short; displayed below item name)</label>
		<input type="text" name="description" id="description" value="{$item.description}" />

		<label for="quality">Item quality</label>
		<select id="quality" name="quality">
			<option value="0" class="q0" {if $item.quality == 0}selected{/if}>Poor</option>
			<option value="1" class="q1" {if $item.quality == 1}selected{/if}>Common</option>
			<option value="2" class="q2" {if $item.quality == 2}selected{/if}>Uncommon</option>
			<option value="3" class="q3" {if $item.quality == 3}selected{/if}>Rare</option>
			<option value="4" class="q4" {if $item.quality == 4}selected{/if}>Epic</option>
			<option value="5" class="q5" {if $item.quality == 5}selected{/if}>Legendary</option>
			<option value="6" class="q6" {if $item.quality == 6}selected{/if}>Artifact</option>
			<option value="7" class="q7" {if $item.quality == 7}selected{/if}>Heirloom</option>
		</select>

		<label>Need character</label>
		<input type="checkbox" id="command_need_character" name="command_need_character" {if $item.command_need_character}checked="yes"{/if} value="1"/>
		<label for="command_need_character" class="inline_label">Make the user select a character</label>

		<label>Require offline</label>
		<input type="checkbox" id="require_character_offline" name="require_character_offline" {if $item.require_character_offline}checked="yes"{/if} value="1"/>
		<label for="require_character_offline" class="inline_label">Make sure the selected character is offline</label>

		<label for="command">Command (Seperate multiple commands by a new line)</label>
		<textarea id="command" name="command">{$item.command}</textarea>
		<span>
			{literal}
				<b>{ACCOUNT}</b> = Account Name, 
				<b>{CHARACTER}</b> = Character Name
			{/literal}
		</span>

		<label for="realm">Realm</label>
		<select name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}" {if $item.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>

		<label for="group">Item group</label>
		<select name="group" id="group">
			<option value="0"  {if $item.group == "0"}selected{/if}>None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}" {if $item.group != 0 && $item.group == $group.id}selected{/if}>{$group.title}</option>
			{/foreach}
		</select>

		<div class="vp_price">
			<label for="vpCost">VP price</label>
			<input type="text" name="vpCost" id="vpCost" value="{$item.vp_price}"/>
		</div>

		<div class="dp_price">
			<label for="dpCost">DP price</label>
			<input type="text" name="dpCost" id="dpCost" value="{$item.dp_price}"/>
		</div>

		<label for="icon">Icon name</label>
		<input type="text" name="icon" id="icon" value="{$item.icon}" />

		<input type="submit" value="Save command" />
	</form>

	<form onSubmit="Items.save(this, {$item.id}); return false" id="query_form" {if !$item.query}style="display:none;"{/if}>

		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="{$item.name}" />

		<label for="description">Description (very short; displayed below item name)</label>
		<input type="text" name="description" id="description" value="{$item.description}" />

		<label for="quality">Item quality</label>
		<select id="quality" name="quality">
			<option value="0" class="q0" {if $item.quality == 0}selected{/if}>Poor</option>
			<option value="1" class="q1" {if $item.quality == 1}selected{/if}>Common</option>
			<option value="2" class="q2" {if $item.quality == 2}selected{/if}>Uncommon</option>
			<option value="3" class="q3" {if $item.quality == 3}selected{/if}>Rare</option>
			<option value="4" class="q4" {if $item.quality == 4}selected{/if}>Epic</option>
			<option value="5" class="q5" {if $item.quality == 5}selected{/if}>Legendary</option>
			<option value="6" class="q6" {if $item.quality == 6}selected{/if}>Artifact</option>
			<option value="7" class="q7" {if $item.quality == 7}selected{/if}>Heirloom</option>
		</select>

		<label for="query_database">Database</label>
		<select id="query_database" name="query_database">
			<option value="cms" {if $item.query_database == "cms"}selected{/if}>CMS</option>
			<option value="realm" {if $item.query_database == "realm"}selected{/if}>Realm (characters)</option>
			<option value="realmd" {if $item.query_database == "realmd"}selected{/if}>Realmd (accounts/auth/logon)</option>
		</select>

		<label>Need character</label>
		<input type="checkbox" id="query_need_character" name="query_need_character" {if $item.query_need_character}checked="yes"{/if} value="1"/>
		<label for="query_need_character" class="inline_label">Make the user select a character</label>

		<label>Require offline</label>
		<input type="checkbox" id="require_character_offline" name="require_character_offline" {if $item.require_character_offline}checked="yes"{/if} value="1"/>
		<label for="require_character_offline" class="inline_label">Make sure the selected character is offline</label>

		<label for="query" data-tip="Example query: UPDATE characters SET level = 80 WHERE guid = {literal}{CHARACTER}{/literal}">SQL query <a>(?)</a></label>
		<textarea id="query" name="query">{$item.query}</textarea>
		<span>
			{literal}
				<b>{ACCOUNT}</b> = Account ID, 
				<b>{CHARACTER}</b> = Character ID, 
				<b>{REALM}</b> = Realm ID
			{/literal}
		</span>

		<label for="realm">Realm</label>
		<select name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}" {if $item.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>

		<label for="group">Item group</label>
		<select name="group" id="group">
			<option value="0"  {if $item.group == "0"}selected{/if}>None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}" {if $item.group != 0 && $item.group == $group.id}selected{/if}>{$group.title}</option>
			{/foreach}
		</select>

		<div class="vp_price">
			<label for="vpCost">VP price</label>
			<input type="text" name="vpCost" id="vpCost" value="{$item.vp_price}"/>
		</div>

		<div class="dp_price">
			<label for="dpCost">DP price</label>
			<input type="text" name="dpCost" id="dpCost" value="{$item.dp_price}"/>
		</div>

		<label for="icon">Icon name</label>
		<input type="text" name="icon" id="icon" value="{$item.icon}" />

		<input type="submit" value="Save query" />
	</form>

	<form onSubmit="Items.save(this, {$item.id}); return false" id="item_form" {if $item.query}style="display:none;"{/if}>

		<label for="name">Name (only required for multiple items)</label>
		<input type="text" name="name" id="name" placeholder="Will be added automatically if you only specify one item ID" value="{$item.name}"/>

		<label for="itemid">Item ID (tip: separate ids with , (comma) to add multiple as one)</label>
		<input type="text" name="itemid" id="itemid" placeholder="12345" value="{$item.itemid}" />

		<label for="description">Description (very short; displayed below item name)</label>
		<input type="text" name="description" id="description" placeholder="For example, 'Head (Plate)'" value="{$item.description}"/>

		<label for="realm">Realm</label>
		<select name="realm" id="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}" {if $item.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>

		<label for="group">Item group</label>
		<select name="group" id="group">
			<option value="0" {if $item.group == "0"}selected{/if}>None</option>
			{foreach from=$groups item=group}
				<option value="{$group.id}" {if $item.group != 0 && $item.group == $group.id}selected{/if}>{$group.title}</option>
			{/foreach}
		</select>

		<div class="vp_price">
			<label for="vpCost">VP price</label>
			<input type="text" name="vpCost" id="vpCost" value="{$item.vp_price}"/>
		</div>

		<div class="dp_price">
			<label for="dpCost">DP price</label>
			<input type="text" name="dpCost" id="dpCost" value="{$item.dp_price}"/>
		</div>

		<label for="icon">Icon name</label>
		<input type="text" name="icon" id="icon" value="{$item.icon}" placeholder="Will be added automatically if you leave empty, and only specify one item ID" />

		<input type="submit" value="Save item" />
	</form>
</section>
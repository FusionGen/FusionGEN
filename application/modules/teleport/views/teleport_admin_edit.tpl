<section class="box big">
	<h2>Edit teleport location</h2>

	<form onSubmit="Teleport.save(this, {$teleport_location.id}); return false" id="submit_form">
		<label for="name">Location name</label>
		<input type="text" name="name" id="name" value="{$teleport_location.name}"/>

		<label for="description">Description</label>
		<input type="text" name="description" id="description" value="{$teleport_location.description}"/>

		<label for="realm">Realm</label>
		<select id="realm" name="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}" {if $teleport_location.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>

		<label for="priceType">Price type</label>
		<select id="priceType" name="priceType" onChange="Teleport.changePrice(this)">
			<option value="free" {if !$teleport_location.vpCost && !$teleport_location.dpCost && $teleport_location.goldCost}selected{/if}>Free</option>
			<option value="vp" {if $teleport_location.vpCost}selected{/if}>VP</option>
			<option value="dp" {if $teleport_location.dpCost}selected{/if}>DP</option>
			<option value="gold" {if $teleport_location.goldCost}selected{/if}>Gold</option>
		</select>

		<div id="vp_price" style="display:none;">
			<label for="vpCost">VP price</label>
			<input type="text" name="vpCost" id="vpCost" value="{$teleport_location.vpCost}"/>
		</div>

		<div id="dp_price" style="display:none;">
			<label for="dpCost">DP price</label>
			<input type="text" name="dpCost" id="dpCost" value="{$teleport_location.dpCost}"/>
		</div>

		<div id="gold_price" style="display:none;">
			<label for="goldCost">Gold price</label>
			<input type="text" name="goldCost" id="goldCost" value="{$teleport_location.goldCost}"/>
		</div>
		
		<label for="x">X coordinate</label>
		<input type="text" name="x" id="x" value="{$teleport_location.x}"/>
		
		<label for="y">Y coordinate</label>
		<input type="text" name="y" id="y" value="{$teleport_location.y}"/>
		
		<label for="z">Z coordinate</label>
		<input type="text" name="z" id="z" value="{$teleport_location.z}"/>
		
		<label for="orientation">Orientation</label>
		<input type="text" name="orientation" id="orientation" value="{$teleport_location.orientation}"/>
		
		<label for="mapId">Map ID</label>
		<input type="text" name="mapId" id="mapId" value="{$teleport_location.mapId}"/>

		<label for="required_faction">Required faction</label>
		<select id="required_faction" name="required_faction">
			<option value="0" {if $teleport_location.required_faction == 0}selected{/if}>Any</option>
			<option value="1" {if $teleport_location.required_faction == 1}selected{/if}>Alliance</option>
			<option value="2" {if $teleport_location.required_faction == 2}selected{/if}>Horde</option>
		</select>
		
		<input type="submit" value="Save location" />
	</form>
</section>
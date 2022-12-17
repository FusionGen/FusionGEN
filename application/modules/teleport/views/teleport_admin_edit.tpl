<div class="card">
	<div class="card-header">Edit teleport location</div>

	<div class="card-body">
	<form role="form" onSubmit="Teleport.save(this, {$teleport_location.id}); return false" id="submit_form">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Location name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" value="{$teleport_location.name}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description" value="{$teleport_location.description}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control" id="realm" name="realm">
			{foreach from=$realms item=realm}
				<option class="form-control" value="{$realm->getId()}" {if $teleport_location.realm == $realm->getId()}selected{/if}>{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="priceType">Price type</label>
		<div class="col-sm-10">
		<select class="form-control" id="priceType" name="priceType" onChange="Teleport.changePrice(this)">
			<option value="free" {if !$teleport_location.vpCost && !$teleport_location.dpCost && $teleport_location.goldCost}selected{/if}>Free</option>
			<option value="vp" {if $teleport_location.vpCost}selected{/if}>VP</option>
			<option value="dp" {if $teleport_location.dpCost}selected{/if}>DP</option>
			<option value="gold" {if $teleport_location.goldCost}selected{/if}>Gold</option>
		</select>
		</div>
		</div>

		<div id="vp_price" style="display:none;">
		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
			<div class="col-sm-10">
			<input class="form-control" type="text" name="vpCost" id="vpCost" value="{$teleport_location.vpCost}"/>
		</div>
		</div>
		</div>

		<div id="dp_price" style="display:none;">
		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
			<div class="col-sm-10">
			<input class="form-control" type="text" name="dpCost" id="dpCost" value="{$teleport_location.dpCost}"/>
		</div>
		</div>
		</div>

		<div id="gold_price" style="display:none;">
		<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="goldCost">Gold price</label>
			<div class="col-sm-10">
			<input class="form-control" type="text" name="goldCost" id="goldCost" value="{$teleport_location.goldCost}"/>
		</div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="x">X coordinate</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" name="x" id="x" value="{$teleport_location.x}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="y">Y coordinate</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="y" id="y" value="{$teleport_location.y}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="z">Z coordinate</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="z" id="z" value="{$teleport_location.z}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="orientation">Orientation</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="orientation" id="orientation" value="{$teleport_location.orientation}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="mapId">Map ID</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="mapId" id="mapId" value="{$teleport_location.mapId}"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="required_faction">Required faction</label>
		<div class="col-sm-10">
		<select class="form-control" id="required_faction" name="required_faction">
			<option value="0" {if $teleport_location.required_faction == 0}selected{/if}>Any</option>
			<option value="1" {if $teleport_location.required_faction == 1}selected{/if}>Alliance</option>
			<option value="2" {if $teleport_location.required_faction == 2}selected{/if}>Horde</option>
		</select>
		</div>
		</div>
		
		<button type="submit" class="btn btn-primary btn-sm">Save location</button>
	</div>
	</form>
</div>
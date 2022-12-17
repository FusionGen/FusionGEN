<div class="card">
	<div class="card-header">New teleport location</div>

	<div class="card-body">
	<form role="form" onSubmit="Teleport.create(this); return false" id="submit_form">

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Location name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realm">Realm</label>
		<div class="col-sm-10">
		<select class="form-control" id="realm" name="realm">
			{foreach from=$realms item=realm}
				<option class="form-control" value="{$realm->getId()}">{$realm->getName()}</option>
			{/foreach}
		</select>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="priceType">Price type</label>
		<div class="col-sm-10">
		<select class="form-control" id="priceType" name="priceType" onChange="Teleport.changePrice(this)">
			<option value="free">Free</option>
			<option value="vp">VP</option>
			<option value="dp">DP</option>
			<option value="gold">Gold</option>
		</select>
		</div>
		</div>

		<div id="vp_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="vpCost">VP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="vpCost" id="vpCost" value="0"/>
		</div>
		</div>
		</div>

		<div id="dp_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="dpCost">DP price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="dpCost" id="dpCost" value="0"/>
		</div>
		</div>
		</div>

		<div id="gold_price" style="display:none;">
		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="goldCost">Gold price</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="goldCost" id="goldCost" value="0"/>
		</div>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="x">X coordinate</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="x" id="x"/>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="y">Y coordinate</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="y" id="y"/>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="z">Z coordinate</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="z" id="z"/>
		</div>
		</div>
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="orientation">Orientation</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="orientation" id="orientation"/>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="mapId">Map ID</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="mapId" id="mapId"/>
		</div>
		</div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="required_faction">Required faction</label>
		<div class="col-sm-10">
		<select class="form-control" id="required_faction" name="required_faction">
			<option value="0">Any</option>
			<option value="1">Alliance</option>
			<option value="2">Horde</option>
		</select>
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit location</button>
	</div>
	</form>
</div>
<section class="box big" id="main_teleport">
	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_picture.png"/>
		Teleport locations (<div style="display:inline;" id="teleport_count">{if !$teleport_locations}0{else}{count($teleport_locations)}{/if}</div>)
	</h2>

	{if hasPermission("canAdd")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Teleport.add()">Create teleport location</a>
		</span>
	{/if}

	<ul id="teleport_locationr_list">
		{if $teleport_locations}
			{foreach from=$teleport_locations item=teleport_location}
				<li>
					<table width="100%">
						<tr>
							<td width="20%"><b>{$teleport_location.name}</b></td>
							<td width="25%">{$teleport_location.description}</td>
							<td width="25%">{$teleport_location.realmName}</td>
							<td width="15%">
								{if $teleport_location.vpCost}
									<img src="{$url}application/images/icons/lightning.png" style="opacity:1;margin-top:3px;position:absolute;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$teleport_location.vpCost} VP
								{elseif $teleport_location.dpCost}
									<img src="{$url}application/images/icons/coins.png" style="opacity:1;margin-top:3px;position:absolute;"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									{$teleport_location.dpCost} DP
								{elseif $teleport_location.goldCost}
								<img src="{$url}application/images/icons/coins.png" style="opacity:1;margin-top:3px;position:absolute;"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									{$teleport_location.goldCost} Gold
								{else}
									Free
								{/if}
							</td>
							<td style="text-align:right;">
								{if hasPermission("canEdit")}
								<a href="{$url}teleport/admin/edit/{$teleport_location.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
								{/if}

								{if hasPermission("canRemove")}
									<a href="javascript:void(0)" onClick="Teleport.remove({$teleport_location.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
								{/if}
							</td>
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>

<section class="box big" id="add_teleport" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Teleport.add()" data-tip="Return to teleport locations">Teleport locations</a> &rarr; New teleport location</h2>

	<form onSubmit="Teleport.create(this); return false" id="submit_form">

		<label for="name">Location name</label>
		<input type="text" name="name" id="name"/>

		<label for="description">Description</label>
		<input type="text" name="description" id="description"/>

		<label for="realm">Realm</label>
		<select id="realm" name="realm">
			{foreach from=$realms item=realm}
				<option value="{$realm->getId()}">{$realm->getName()}</option>
			{/foreach}
		</select>

		<label for="priceType">Price type</label>
		<select id="priceType" name="priceType" onChange="Teleport.changePrice(this)">
			<option value="free">Free</option>
			<option value="vp">VP</option>
			<option value="dp">DP</option>
			<option value="gold">Gold</option>
		</select>

		<div id="vp_price" style="display:none;">
			<label for="vpCost">VP price</label>
			<input type="text" name="vpCost" id="vpCost" value="0"/>
		</div>

		<div id="dp_price" style="display:none;">
			<label for="dpCost">DP price</label>
			<input type="text" name="dpCost" id="dpCost" value="0"/>
		</div>

		<div id="gold_price" style="display:none;">
			<label for="goldCost">Gold price</label>
			<input type="text" name="goldCost" id="goldCost" value="0"/>
		</div>
		
		<label for="x">X coordinate</label>
		<input type="text" name="x" id="x"/>
		
		<label for="y">Y coordinate</label>
		<input type="text" name="y" id="y"/>
		
		<label for="z">Z coordinate</label>
		<input type="text" name="z" id="z"/>
		
		<label for="orientation">Orientation</label>
		<input type="text" name="orientation" id="orientation"/>
		
		<label for="mapId">Map ID</label>
		<input type="text" name="mapId" id="mapId"/>

		<label for="required_faction">Required faction</label>
		<select id="required_faction" name="required_faction">
			<option value="0">Any</option>
			<option value="1">Alliance</option>
			<option value="2">Horde</option>
		</select>

		<input type="submit" value="Submit location" />
	</form>
</section>
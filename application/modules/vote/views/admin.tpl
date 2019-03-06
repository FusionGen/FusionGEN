<section class="box big" id="main_topsites">
	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_list.png"/>
		Topsites (<div style="display:inline;" id="topsites_count">{if !$topsites}0{else}{count($topsites)}{/if}</div>)
	</h2>

	{if hasPermission("canCreate")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Topsites.add()">Create topsite</a>
		</span>
	{/if}

	<ul id="topsites_list">
		{if $topsites}
			{foreach from=$topsites item=vote_site}
				<li>
					<table width="100%">
						<tr>
							<td width="30%">{if $vote_site.vote_image}<img src="{$vote_site.vote_image}" style="opacity:1;" />{else}{$vote_site.vote_sitename}{/if}</td>
							<td width="30%">{$vote_site.points_per_vote} voting point{if $vote_site.points_per_vote > 1}s{/if}</td>
							<td width="30%">{$vote_site.hour_interval} hours</td>
							<td style="text-align:right;">
								{if hasPermission("canEdit")}
								<a href="{$url}vote/admin/edit/{$vote_site.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
								{/if}

								{if hasPermission("canDelete")}
								<a href="javascript:void(0)" onClick="Topsites.remove({$vote_site.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
								{/if}
							</td>
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>

<section class="box big" id="add_topsites" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Topsites.add()" data-tip="Return to topsites">Topsites</a> &rarr; New topsite</h2>

	<form onSubmit="Topsites.create(this); return false" id="submit_form">

		<label for="vote_url">Your vote link</label>
		<input type="text" name="vote_url" id="vote_url" placeholder="http://" onChange="Topsites.check(this)" />

		<label for="vote_sitename">Site title</label>
		<input type="text" name="vote_sitename" id="vote_sitename"/>

		<label for="vote_image">Vote site image (will be auto-completed if URL is recognized)</label>
		<input type="text" name="vote_image" id="vote_image" placeholder="(optional)" onChange="Topsites.updateImagePreview(this.value)"/>
		
		<div id="vote_image_preview" style="display:none">
			<small>Preview:</small><br />
			<img alt="Loading..." />
		</div>
		
		<label for="hour_interval">Hour interval</label>
		<input type="text" name="hour_interval" id="hour_interval" value="12"/>

		<label for="points_per_vote">Vote points per vote</label>
		<input type="text" name="points_per_vote" id="points_per_vote" value="1"/>

		<label for="callback_enabled" data-tip="If enabled, vote points are only credited if the user has actually voted. Not all topsites support this feature.">Enable vote verification (<a>?</a>)</label>
		<div id="callback_form">
			<div class="not-supported">This topsite is not supported.</div>
			
			<div class="form" style="display:none">
				<select id="callback_enabled" name="callback_enabled" onChange="Topsites.updateLinkFormat()">
					<option value="0" selected>No</option>
					<option value="1">Yes</option>
				</select>
				
				<div class="dropdown help">
					<h3>How to configure vote verification for </h3>
					<div>
						
					</div>
				</div>
			</div>
		</div>

		<input type="submit" value="Submit topsite" />
	</form>
</section>
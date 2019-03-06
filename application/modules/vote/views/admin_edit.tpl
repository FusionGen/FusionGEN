<section class="box big">
	<h2>Edit topsite</h2>

	<form onSubmit="Topsites.save(this, {$topsite.id}); return false" id="submit_form">
		<label for="vote_url">Your vote link</label>
		<input type="text" name="vote_url" id="vote_url" placeholder="http://" onChange="Topsites.check(this)" value="{$topsite.vote_url}" {if isset($topsite.votelink_format)}data-format="{$topsite.votelink_format}"{/if} />
		
		<label for="vote_sitename">Site title</label>
		<input type="text" name="vote_sitename" id="vote_sitename" value="{$topsite.vote_sitename}"/>

		<label for="vote_image">Vote site image (will be auto-completed if URL is recognized)</label>
		<input type="text" name="vote_image" id="vote_image" placeholder="(optional)" value="{$topsite.vote_image}" onChange="Topsites.updateImagePreview(this.value)" />

		<div id="vote_image_preview" {if ! $topsite.vote_image}style="display:none"{/if}>
			<small>Preview:</small><br />
			<img src="{$topsite.vote_image}" alt="Loading..." />
		</div>

		<label for="hour_interval">Hour interval</label>
		<input type="text" name="hour_interval" id="hour_interval" value="{$topsite.hour_interval}"/>

		<label for="points_per_vote">Vote points per vote</label>
		<input type="text" name="points_per_vote" id="points_per_vote" value="{$topsite.points_per_vote}"/>
		
		<label for="callback_enabled" data-tip="If enabled, vote points are only credited if the user has actually voted. Not all topsites support this feature.">Enable vote verification (<a>?</a>)</label>
		<div id="callback_form">
			<div class="not-supported" {if $topsite.callback_support}style="display:none"{/if}>Vote verification is not supported for this topsite.</div>
			
			<div class="form" {if ! $topsite.callback_support}style="display:none"{/if}>
				<select id="callback_enabled" name="callback_enabled" onChange="Topsites.updateLinkFormat()">
					<option value="0"{if ! $topsite.callback_enabled} selected{/if}>No</option>
					<option value="1"{if $topsite.callback_enabled} selected{/if}>Yes</option>
				</select>
				
				<div class="dropdown help">
					<h3>
						How to configure vote verification for 
						<span class="sitename" style="display:inline;margin:0;padding:0">
							{if isset($topsite.topsite_url)}{$topsite.topsite_url}{/if}
						</span>
					</h3>
					<div>
						{if isset($topsite.callback_help)}
							{$topsite.callback_help}
						{/if}
					</div>
				</div>
			</div>
		</div>

		<input type="submit" value="Save topsite" />
	</form>
</section>
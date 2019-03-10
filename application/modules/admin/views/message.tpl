{if hasPermission("toggleMessage")}
<section class="box big">
	<h2>Message</h2>
	<span>
		This will temporarily disable the entire site to display the message until you turn it off.<br /><br />To directly access the admin panel, please go to <a href="{$url}admin/">{$url}admin/</a>
	</span>

	<form onSubmit="Settings.submitMessage(this);return false">
		
		<label for="message_enabled">Global announcement message</label>
		<select id="message_enabled" name="message_enabled">
			<option value="true" {if $message_enabled}selected{/if}>Enabled</div>
			<option value="false" {if !$message_enabled}selected{/if}>Disabled</div>
		</select>

		<label for="message_headline">Headline</label>
		<input type="text" id="message_headline" name="message_headline" value="Maintenance" onKeyUp="Settings.liveUpdate(this, 'headline')"/>
		
		<label for="message_headline_size">Headline size (default: 56)</label>
		<input type="text" id="message_headline_size" name="message_headline_size" value="56" onKeyUp="Settings.liveUpdate(this, 'headline_size')"/>

		<label for="message_text">Message</label>
		<textarea id="message_text" name="message_text" rows="10" onKeyUp="Settings.liveUpdate(this, 'text')">The Website is currently down for maintenance, please come back later! -FusionGEN</textarea>

		<input type="submit" value="Save config" />
	</form>
</section>
{/if}

<section class="box big">
	<h2>Preview</h2>
	<span>
		<span class="announcement">
		<h3 id="live_headline" style="font-size:56px;">Maintenance</h3>
		<p id="live_text">The Website is currently down for maintenance, please come back later! -FusionGEN</p>
		</span>
	</span>
</section>
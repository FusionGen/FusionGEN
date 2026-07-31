{if hasPermission("toggleMessage")}
<div class="card">
	<header class="card-header">Message
	<span class="pull-right">
		<i class="fa-solid fa-triangle-exclamation"></i> This will temporarily disable the entire site to display the message until you turn it off.
	</span>
	</header>

	<div class="card-body">
	<form onSubmit="Settings.submitMessage(this);return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_enabled">Global maintenance message</label>
		<div class="col-sm-10">
		<select class="form-control" id="message_enabled" name="message_enabled">
			<option value="true" {if $message_enabled}selected{/if}>Enabled</div>
			<option value="false" {if !$message_enabled}selected{/if}>Disabled</div>
		</select>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_headline">Headline</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="message_headline" name="message_headline" value="{$message_headline}" onKeyUp="Settings.liveUpdate(this, 'headline')">
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_headline_size">Headline size (default: 56)</label>
		<div class="col-sm-10">
        <div data-plugin-spinner>
            <div class="input-group">
                <input class="spinner-input form-control" type="text" name="message_headline_size" id="message_headline_size" value="{$message_headline_size}" onKeyUp="Settings.liveUpdate(this, 'headline_size')">
                <div class="spinner-buttons input-group-btn btn-group-vertical">
                    <button type="button" class="btn spinner-up btn-xs btn-default" onclick="Settings.liveUpdate(message_headline_size, 'headline_size')">
                        <i class="fas fa-angle-up"></i>
                    </button>
                    <button type="button" class="btn spinner-down btn-xs btn-default" onclick="Settings.liveUpdate(message_headline_size, 'headline_size')">
                        <i class="fas fa-angle-down"></i>
                    </button>
                </div>
            </div>
        </div>
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="message_text">Message</label>
		<div class="col-sm-10">
		<textarea class="form-control mb-3" id="message_text" name="message_text" rows="10" onKeyUp="Settings.liveUpdate(this, 'text')">{$message_text}</textarea>
		</div>
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Save message</button>
	</form>
	</div>
</div>
{/if}

<div class="card">
	<div class="card-header">Preview</div>
	<div class="card-body">
		<span class="text-center">
		<h3 id="live_headline" style="font-size:{$message_headline_size}px;">{$message_headline}</h3>
		<p id="live_text">{$message_text}</p>
		</span>
	</div>
</div>

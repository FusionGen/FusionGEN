{foreach from=$configs item=config key=title}

<div class="card">
	<header class="card-header">{$title}.php</header>
<div class="card-body">
	{if array_key_exists('force_code_editor', $config) && $config['force_code_editor']}
		<form role="form" onSubmit="Settings.submitConfigSource('{$moduleName}', '{$title}');return false" id="advanced_{$title}">
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="source_{$title}">Source code</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="source_{$title}" name="source_{$title}" rows="15" spellcheck="false">{$config.source}</textarea>
			</div>
			</div>
			<button type="submit" class="btn btn-primary">Save config</button>
		</form>
	{else}
		<button class="btn btn-primary btn-sm mb-3" href="javascript:void(0)" onClick="Settings.toggleSource('{$title}', this)">Edit source code (advanced)</button>

		<form role="form" onSubmit="Settings.submitConfigSource('{$moduleName}', '{$title}');return false" id="advanced_{$title}" style="display:none;">
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="source_{$title}">Source code</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="source_{$title}" name="source_{$title}" rows="15" spellcheck="false">{$config.source}</textarea>
			</div>
			</div>
			<button type="submit" class="btn btn-primary">Save config</button>
		</form>

		<form role="form" onSubmit="Settings.submitConfig(this, '{$moduleName}', '{$title}');return false" id="gui_{$title}">
			{foreach from=$config item=option key=label}
			<div class="form-group row">
				{if $label != "source"}
					{if is_array($option) && ctype_digit(implode('', array_keys($option)))}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" value="{foreach from=$option item=value}{$value},{/foreach}" id="{$label}" name="{$label}" />
						</div>
					{elseif is_array($option)}	
						<label class="col-sm-2 col-form-label" for="{$label}"><b>{ucfirst(preg_replace("/_/", " ", $label))}</b></label>
						{foreach from=$option item=sub_option key=sub_label}		
							{if is_array($sub_option) && ctype_digit(implode('', array_keys($sub_option)))}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" value="{foreach from=$sub_option item=value}{$value},{/foreach}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								</div>
							{elseif is_array($sub_option)}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}"><b>{ucfirst(preg_replace("/_/", " ", $sub_label))}</b></label>
								test
							{elseif $sub_option === true}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
								<select class="form-control" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
									<option selected value="true">Yes</option>
									<option value="false">No</option>
								</select>
								</div>
							{elseif $sub_option === false}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
								<select class="form-control" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
									<option value="true">Yes</option>
									<option selected value="false">No</option>
								</select>
								</div>
							{else}
								<label class="col-sm-2 col-form-label" for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" value="{$sub_option}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								</div>
							{/if}
						{/foreach}
					{elseif $option === true}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
						<select class="form-control" id="{$label}" name="{$label}">
							<option selected value="true">Yes</option>
							<option value="false">No</option>
						</select>
						</div>
					{elseif $option === false}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
						<select class="form-control" id="{$label}" name="{$label}">
							<option value="true">Yes</option>
							<option selected value="false">No</option>
						</select>
						</div>
					{else}
						<label class="col-sm-2 col-form-label" for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" value="{$option}" id="{$label}" name="{$label}" />
						</div>
					{/if}
				{/if}
				</div>
			{/foreach}
			
			<button type="submit" class="btn btn-primary btn-sm">Save config</button>
		</form>
	{/if}
</div>
</div>
{/foreach}
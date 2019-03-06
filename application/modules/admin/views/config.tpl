{foreach from=$configs item=config key=title}

	<section class="box big">
		<h2>{$title}.php</h2>

		{if array_key_exists('force_code_editor', $config) && $config['force_code_editor']}
			<form onSubmit="Settings.submitConfigSource('{$moduleName}', '{$title}');return false" id="advanced_{$title}">
				<label for="source_{$title}">Source code</label>

				<textarea id="source_{$title}" name="source_{$title}" rows="30" spellcheck="false">{$config.source}</textarea>

				<input type="submit" value="Save config" />
			</form>
		{else}
			<span>
				<a class="nice_button" href="javascript:void(0)" onClick="Settings.toggleSource('{$title}', this)">Edit source code (advanced)</a>
			</span>

			<form onSubmit="Settings.submitConfigSource('{$moduleName}', '{$title}');return false" id="advanced_{$title}" style="display:none;">
				<label for="source_{$title}">Source code</label>

				<textarea id="source_{$title}" name="source_{$title}" rows="30" spellcheck="false">{$config.source}</textarea>

				<input type="submit" value="Save config" />
			</form>

			<form onSubmit="Settings.submitConfig(this, '{$moduleName}', '{$title}');return false" id="gui_{$title}">

				{foreach from=$config item=option key=label}
					{if $label != "source"}
						{if is_array($option) && ctype_digit(implode('', array_keys($option)))}
							<label for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
							<input type="text" value="{foreach from=$option item=value}{$value},{/foreach}" id="{$label}" name="{$label}" />
						{elseif is_array($option)}	
							<label for="{$label}"><b>{ucfirst(preg_replace("/_/", " ", $label))}</b></label>
							{foreach from=$option item=sub_option key=sub_label}		
								{if is_array($sub_option) && ctype_digit(implode('', array_keys($sub_option)))}
									<label for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
									<input type="text" value="{foreach from=$sub_option item=value}{$value},{/foreach}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								{elseif is_array($sub_option)}
									<label for="{$label}-{$sub_label}"><b>{ucfirst(preg_replace("/_/", " ", $sub_label))}</b></label>
									test
								{elseif $sub_option === true}
									<label for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
									<select id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
										<option selected value="true">Yes</div>
										<option value="false">No</div>
									</select>
								{elseif $sub_option === false}
									<label for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
									<select id="{$label}-{$sub_label}" name="{$label}-{$sub_label}">
										<option value="true">Yes</div>
										<option selected value="false">No</div>
									</select>
								{else}
									<label for="{$label}-{$sub_label}">{ucfirst(preg_replace("/_/", " ", $sub_label))}</label>
									<input type="text" value="{$sub_option}" id="{$label}-{$sub_label}" name="{$label}-{$sub_label}" />
								{/if}
							{/foreach}
						{elseif $option === true}
							<label for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
							<select id="{$label}" name="{$label}">
								<option selected value="true">Yes</div>
								<option value="false">No</div>
							</select>
						{elseif $option === false}
							<label for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
							<select id="{$label}" name="{$label}">
								<option value="true">Yes</div>
								<option selected value="false">No</div>
							</select>
						{else}
							<label for="{$label}">{ucfirst(preg_replace("/_/", " ", $label))}</label>
							<input type="text" value="{$option}" id="{$label}" name="{$label}" />
						{/if}
					{/if}
				{/foreach}

				<input type="submit" value="Save config" />
			</form>
		{/if}
	</section>
{/foreach}
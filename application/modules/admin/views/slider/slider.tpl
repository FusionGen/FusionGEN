{if hasPermission("editSlider")}
<section class="box big">
	<h2>Slider settings</h2>

	<form onSubmit="Slider.saveSettings(this); return false">
		<label for="show_slider">Visibility</label>
		<select name="show_slider" id="show_slider">
			<option value="home" {if $slider && $slider_home}selected{/if}>Only on homepage</option>
			<option value="always" {if $slider && !$slider_home}selected{/if}>Always</option>
			<option value="never" {if !$slider}selected{/if}>Never</option>
		</select>

		<label for="slider_interval">Slider interval (in seconds)</label>
		<input type="text" name="slider_interval" id="slider_interval" value="{$slider_interval/1000}"/>

		<label for="slider_style">Slider transition style</label>
		<select name="slider_style" id="slider_style">
			<option value="" {if !$slider_style}selected{/if}>Random (all)</option>
			<option value="bars" {if $slider_style == "bars"}selected{/if}>Bars</option>
			<option value="blinds" {if $slider_style == "blinds"}selected{/if}>Blinds</option>
			<option value="blocks" {if $slider_style == "blocks"}selected{/if}>Blocks</option>
			<option value="blocks2" {if $slider_style == "blocks2"}selected{/if}>Blocks2</option>
			<option value="concentric" {if $slider_style == "concentric"}selected{/if}>Concentric</option>
			<option value="dissolve" {if $slider_style == "dissolve"}selected{/if}>Dissolve</option>
			<option value="slide" {if $slider_style == "slide"}selected{/if}>Slide</option>
			<option value="warp" {if $slider_style == "warp"}selected{/if}>Warp</option>
			<option value="zip" {if $slider_style == "zip"}selected{/if}>Zip</option>
			<option value="bars3d" {if $slider_style == "bars3d"}selected{/if}>Bars3d</option>
			<option value="blinds3d" {if $slider_style == "blinds3d"}selected{/if}>Blinds3d</option>
			<option value="cube" {if $slider_style == "cube"}selected{/if}>Cube</option>
			<option value="tiles3d" {if $slider_style == "tiles3d"}selected{/if}>Tiles3d</option>
			<option value="turn" {if $slider_style == "turn"}selected{/if}>Turn</option>
		</select>

		<input type="submit" value="Save settings" />
	</form>
</section>
{/if}

<section class="box big" id="main_slider">
	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_picture.png"/>
		Slides (<div style="display:inline;" id="slides_count">{if !$slides}0{else}{count($slides)}{/if}</div>)
	</h2>

	{if hasPermission("addSlider")}
	<span>
		<a class="nice_button" href="javascript:void(0)" onClick="Slider.add()">Create slide</a>
	</span>
	{/if}

	<ul id="slider_list">
		{if $slides}
		{foreach from=$slides item=slide}
			<li>
				<table width="100%">
					<tr>
						<td width="10%">
							{if hasPermission("editSlider")}
								<a href="javascript:void(0)" onClick="Slider.move('up', {$slide.id}, this)" data-tip="Move up"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_up.png" /></a>
								<a href="javascript:void(0)" onClick="Slider.move('down', {$slide.id}, this)" data-tip="Move down"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_down.png" /></a>
							{/if}
						</td>
						<td width="25%"><b>{$slide.image}</b></td>
						<td width="30%">{$slide.text}</td>
						<td width="20%"><a href="{$slide.link}" target="_blank">{$slide.link_short}</a></td>
						<td style="text-align:right;">
							{if hasPermission("editSlider")}
							<a href="{$url}admin/slider/edit/{$slide.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>
							{/if}
							&nbsp;
							{if hasPermission("deleteSlider")}
							<a href="javascript:void(0)" onClick="Slider.remove({$slide.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
							{/if}
						</td>
					</tr>
				</table>
			</li>
		{/foreach}
		{/if}
	</ul>
</section>

<section class="box big" id="add_slider" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Slider.add()" data-tip="Return to slides">Slides</a> &rarr; New slide</h2>

	<form onSubmit="Slider.create(this); return false" id="submit_form">
		<label for="image">Image URL</label>
		<input type="text" name="image" id="image" placeholder="http://"/>

		<label for="link">Link (optional)</label>
		<input type="text" name="link" id="link" placeholder="http://"/>

		<label for="text">Image text (optional)</label>
		<input type="text" name="text" id="text"/>

		<input type="submit" value="Submit slide" />
	</form>
</section>
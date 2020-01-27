{if hasPermission("canAddChange")}
	<div id="changelog_add">


		{if hasPermission("canAddChange")}
		<form id="change_form" onSubmit="Changelog.addChange(); return false" style="display:none;">
			{if !count($categories)}
				Please add a category first
			{else}
			</br><input type="text" placeholder="{lang("change_info", "changelog")}" id="change_text" name="change" style="width:62%" />
			<select style="width:20%" name="category" id="changelog_types">
				{foreach from=$categories item=category}
					<option value="{$category.id}">{$category.typeName}</option>
				{/foreach}
			</select>
			<input type="submit" value="{lang("add", "changelog")}"/>
			{/if}
		</form>
		{/if}

		{if hasPermission("canAddCategory")}
<div class="button_align">
		
			{form_open('changelog/addCategory', $attributes)}
				<input type="text" placeholder="{lang("category_name", "changelog")}" name="category" style="width:63%" />
				<input type="submit" value="{lang("add", "changelog")}"/>
			</form>
		{/if}
		{if hasPermission("canAddChange")}
			<a href="javascript:void(0)" onClick="$('#category_form').hide();$('#change_form').fadeToggle(150)" class="nice_button">{lang("new_change", "changelog")}</a>
		{/if}
		
		{if hasPermission("canAddCategory")}
			</br></br></br><a href="javascript:void(0)" onClick="$('#change_form').hide();$('#category_form').fadeToggle(150)" class="nice_button">{lang("new_category", "changelog")}</a>
		{/if}

	</div>
</div>
{/if}

{if $changes}
<div id="changelog">
	{foreach from=$changes key=k item=change_time}
		<table class="nice_table">
			<tr>
				<td><div class="changelog_info">{lang("changes_made_on", "changelog")} {$k}</div></td>
			</tr>
			{foreach from=$change_time key=k_type item=change_type}
				
				<tr>
					<td><a>{htmlspecialchars($k_type)}</a></td>
				</tr>

				{foreach from=$change_type item=change}
					<tr>
						<td>{if hasPermission("canRemoveChange")}<a href="{$url}changelog/remove/{$change.change_id}" style="display:inline !important;margin:0px !important;"><img src="{$url}application/images/icons/delete.png" align="absmiddle" /></a>{/if} &nbsp;{htmlspecialchars($change.changelog)}</td>
					</tr>
				{/foreach}
				
			{/foreach}
		</table>
	{/foreach}
</div>
{else}
	<div id="changelog">
		<center style="padding:10px;">{lang("no_changes", "changelog")}</center>
	</div>
{/if}
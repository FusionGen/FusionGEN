<form onSubmit="Settings.submitInfo(); return false" id="settings_info" class="page_form">
	<table style="width:90%">
		<tr>
			<td style="width:25% !important"><label for="nickname_field">Nickname</label></td>
			<td><input type="text" name="nickname_field" id="nickname_field" value="{$nickname}"/></td>
		</tr>
		<tr>
			<td style="width:25% !important"><label for="location_field">Location</label></td>
			<td><input type="text" name="location_field" id="location_field" value="{$location}"/></td>
		</tr>
		{if $show_language_chooser}
			<tr>
				<td style="width:25% !important"><label for="language_field">Website language</label></td>
				<td>
					<select name="language_field" id="language_field">
						{foreach from=$languages item=language}
							<option value="{$language}" {if $userLanguage == $language}selected="selected"{/if}>{ucfirst($language)}</option>
						{/foreach}
					</select>
				</td>
			</tr>
		{/if}
	</table>

	<center style="margin-bottom:10px;">
		<input type="submit" value="Change information" />
	</center>

	<div id="settings_info_ajax" style="text-align:center;padding:10px;"></div>
</form>
<div class="ucp_divider"></div>
<form onSubmit="Settings.submit(); return false" id="settings" class="page_form">
	<table style="width:90%">
		<tr>
			<td style="width:25% !important"><label for="old_password">Old password</label></td>
			<td><input type="password" name="old_password" id="old_password"/></td>
		</tr>
		<tr>
			<td><label for="new_password">New password</label></td>
			<td><input type="password" name="new_password" id="new_password"/></td>
		</tr>
		<tr>
			<td><label for="new_password_confirm">Confirm password</label></td>
			<td><input type="password" name="new_password_confirm" id="new_password_confirm"/></td>
		</tr>
	</table>

	<center style="margin-bottom:10px;">
		<input type="submit" value="Change password" />
	</center>

	<div id="settings_ajax" style="text-align:center;padding:10px;"></div>
</form>
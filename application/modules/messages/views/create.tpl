<div id="pm_spot">
	
	<table width="100%">
		<tr>
			<td width="12%" valign="top" style="padding-top:15px;"><label for="pm_username">{lang("recipient", "messages")}</label></td>
			<td>
				<input type="text" name="pm_username" id="pm_username" placeholder="{lang("search", "messages")}" onKeyUp="Create.autoComplete(this)" {if $username}value="{$username}"{/if}/>
				<div id="pm_username_autocomplete"></div>
			</td>
			<td width="5%" style="text-align:right;padding-top:15px;" valign="top">
				<span id="pm_username_error">{if $username}<img src="{$url}application/images/icons/accept.png"/>{/if}</span>
			</td>
		</tr>
		<tr>
			<td><label for="pm_title">{lang("title", "messages")}</label></td>
			<td>
				<input type="text" name="pm_title" id="pm_title" maxlength="50" placeholder="{lang("hi_there", "messages")}" onBlur="Create.validateTitle(this)"/>
			</td>
			<td style="text-align:right;">
				<span id="pm_title_error"></span>
			</td>
		</tr>
	</table>

	<div style="height:10px"></div>
	{$editor}

	<div style="height:10px"></div>

	<form onSubmit="Create.send(); return false">
		<center><input type="submit" value="{lang("send", "messages")}" /></center>
	</form>

	<div style="height:10px"></div>
</div>
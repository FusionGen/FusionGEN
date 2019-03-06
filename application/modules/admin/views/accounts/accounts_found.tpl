<form onSubmit="Accounts.save(this, {$external_details.id}); return false" id="submit_form">
	<label>Account</label>
	({$external_details.id}) <b>{$external_details.username}</b>

	<label>Last log in</label>
	<b>{$external_details.last_login}</b> by <b>{$external_details.last_ip}</b>

	<label for="vp">VP</label>
	<input type="text" id="vp" name="vp" value="{$internal_details.vp}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="dp">DP</label>
	<input type="text" id="dp" name="dp" value="{$internal_details.dp}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="nickname">Nickname</label>
	<input type="text" id="nickname" name="nickname" value="{$internal_details.nickname}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="email">Email</label>
	<input type="text" id="email" name="email" value="{$external_details.email}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="group">Website user group</label>
	<div style="background-color: #fff;border-radius: 5px;padding: 5px 10px;border: 1px solid #ccc;">Please assign groups at <a href="{$url}admin/aclmanager/groups">the group manager</a></div>

	<label for="password">Change password</label>
	<input type="text" id="password" name="password" placeholder="Enter a new password" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="gm_level">GM level</label>
	<input type="text" id="gm_level" name="gm_level" value="{if !$access_id.gmlevel}0{else}{$access_id.gmlevel}{/if}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}/>

	<label for="expansion">Expansion</label>
	<select id="expansion" name="expansion" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
		{foreach from=$expansions key=id item=expansion}
			<option value="{$id}" {if $external_details.expansion == $id}selected{/if}>{$expansion}</option>
		{/foreach}
	</select>

	{if hasPermission("editAccounts")}
		<input type="submit" value="Save account" />
	{/if}

	{if hasPermission("editPermissions")}

			<label data-tip="A user can be specifically allowed or denied to perform a certain action.<br />
			By setting a user permission, the value you set overrides the group roles<br />
			(example: the user group is allowed to submit comments, but you set the user<br />
			specifically not to be allowed to - then the user won't be allowed to, despite<br />
			being assigned to a group that is allowed to.)">User permissions <a>(?)</a></label>
			<div id="roles">
				{foreach from=$modules key=name item=module}
					{if $module.manifest}
						<div class="role_module">
							<h3>{ucfirst($module.name)} <span onClick="Accounts.moduleState('arrow_{$module.folderName}', '{$module.folderName}')" style="float: right; padding: 0px;"><div id="arrow_{$module.folderName}" class="arrow" style="cursor: pointer;">&rarr;</div></span></h3>
							<div id="{$module.folderName}" style="display: none;">
								<table width="100%">
									{if $module.manifest}
										{foreach from=$module.manifest key=permissionName item=permission}
											<tr>
												<td width="12%" style="text-align:center;">
													<select name="{$name}-{$permissionName}" id="{$name}-{$permissionName}" {if !hasPermission("editAccounts")}disabled="disabled"{/if}>
														<option value="" selected>-</option>
														<option value="1">Allow</option>
														<option value="0">Deny</option>
													</select>
												</td>
												<td width="30%">&nbsp;&nbsp;<label for="{$name}-{$permissionName}" style="display:inline;border:none;font-weight:bold;">{$permissionName}</label></td>
												<td style="font-size:10px;">{$permission.description} (default: {($permission.default) ? "allow" : "deny"})</td>
											</tr>
										{/foreach}
									{/if}
								</table>
							</div>
						</div>
					{/if}
				{/foreach}
				{if hasPermission("editAccounts")}
					<input type="submit" value="Save account" />
				{/if}
			</div>
	{/if}
</form>
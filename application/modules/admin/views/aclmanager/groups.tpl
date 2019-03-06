<section class="box big" id="main_groups">
	<h2>
		<img src="{$url}application/themes/admin/images/icons/black16x16/ic_users.png"/>
		Groups (<div style="display:inline;" id="groups_count">{if !$groups}0{else}{count($groups)}{/if}</div>)
	</h2>

	{if hasPermission("addPermissions")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Groups.add()">Create group</a>
		</span>
	{/if}

	<ul id="groups_list">
		{if $groups}
			{foreach from=$groups item=group}
				<li>
					<table width="100%">
						<tr>
							<td width="50%" data-tip="{$group.description}"><b style="color:{$group.color} !important;">{$group.name}</b></td>
							<td width="30%">{if $group.memberCount}{$group.memberCount} {($group.memberCount == 1) ? "member" : "members"}{/if}</td>
							<td style="text-align:right;">
								{if hasPermission("editPermissions")}
									<a href="{$url}admin/aclmanager/editGroup/{$group.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
								{/if}

								{if hasPermission("deletePermissions")}
									{if !in_array($group.id, array($guestId, $playerId))}
									<a href="javascript:void(0)" onClick="Groups.remove({$group.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
									{/if}
								{/if}
							</td>
						</tr>
					</table>
				</li>
			{/foreach}
		{/if}
	</ul>
</section>

<section class="box big" id="add_groups" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Groups.add()" data-tip="Return to groups">Groups</a> &rarr; New group</h2>

	<form onSubmit="Groups.create(this); return false" id="submit_form">

		<label for="name">Group name</label>
		<input type="text" name="name" id="name"/>

		<label for="description">Description (optional)</label>
		<input type="text" name="description" id="description"/>

		<label for="color">Group color (optional)</label>
		<input type="color" name="color" id="color" value="#ffffff"/>

		<label for="members">Members</label>
		<span>
			<div class="memberList">
				Members can be added once the group has been created
			</div>
		</span>

		<label for="roles">
			<a href="javascript:void(0)" onClick="$('#visibility input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Visibility permissions
		</label>

		<div id="visibility">
			{if $links}
				<div class="role_module">
					<h3>Menu links</h3>
					{foreach from=$links item=link}
						<table width="100%">
							{if $link.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}"></td>
									<td width="25%">
										<span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span>

										<label for="MENU_{$link.id}" style="	display:inline;border:none;font-weight:bold;">{langColumn($link.name)}</label></td>
									<td style="font-size:10px;">{$link.link}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-tip="This menu link is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Menu links' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span>

										<label style="	display:inline;border:none;font-weight:bold;">{langColumn($link.name)}</label></td>
									<td style="font-size:10px;">{$link.link}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}

			{if $pages}
				<div class="role_module">
					<h3>Custom pages</h3>
					{foreach from=$pages item=page}
						<table width="100%">
							{if $page.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($page.name)}</label></td>
									<td style="font-size:10px;">pages/{$page.identifier}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-tip="This page is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Custom pages' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($page.name)}</label></td>
									<td style="font-size:10px;">pages/{$page.identifier}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}

			{if $sideboxes}
				<div class="role_module">
					<h3>Sideboxes</h3>
					{foreach from=$sideboxes item=sidebox}
						<table width="100%">
							{if $sidebox.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($sidebox.displayName)}</label></td>
									<td style="font-size:10px;">{$sidebox.type}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-tip="This sidebox is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Sideboxes' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($sidebox.displayName)}</label></td>
									<td style="font-size:10px;">{$sidebox.type}</td>
								</tr>
							{/if}		
						</table>
					{/foreach}
				</div>
			{/if}
		</div>

		<label for="roles" data-tip="A role is a pre-defined set of permissions. The color indicates the role's danger-level. Please note that certain permissions may have a default value of 'allowed', such as actions that are meant to be performed by everyone by default.">
			<a href="javascript:void(0)" onClick="$('#roles input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Roles <a>(?)</a>
		</label>
		
		<div id="roles">
			{foreach from=$modules key=name item=module}
				{if $module.db || $module.manifest}
					<div class="role_module">
						<h3>{ucfirst($module.name)}</h3>
						<table width="100%">
							{if $module.db}
								{foreach from=$module.db item=role}
									<tr>
										<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}"></td>
										<td width="25%">Custom role: <label for="{$name}-{$role.name}" style="	display:inline;border:none;font-weight:bold;">{$role.name}</label></td>
										<td style="font-size:10px;">{$role.description}</td>
									</tr>
								{/foreach}
							{/if}
							
							{if $module.manifest}
								{foreach from=$module.manifest key=roleName item=role}
									<tr>
										<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}"></td>
										<td width="25%"><label for="{$name}-{$roleName}" style="display:inline;border:none;font-weight:bold;{if isset($role.color)}color:{$role.color};{/if}">{$roleName}</label></td>
										<td style="font-size:10px;">{$role.description}</td>
									</tr>
								{/foreach}
							{/if}
						</table>
					</div>
				{/if}
			{/foreach}
		</div>

		<input type="submit" value="Submit group" />
	</form>
</section>
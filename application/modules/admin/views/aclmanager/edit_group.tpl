<section class="box big">
	<h2>Edit group</h2>

	<form onSubmit="Groups.save(this, {$group.id}); return false" id="submit_form">

		<label for="name">Group name</label>
		<input type="text" name="name" id="name" value="{$group.name}"/>

		<label for="description">Description (optional)</label>
		<input type="text" name="description" id="description" value="{$group.description}"/>

		<label for="color">Group color (optional)</label>
		<input type="color" name="color" id="color" value="{$group.color}"/>

		<label for="members">Members</label>
		<span>
			<div class="memberList">
				
				{if $group.id == $guestId}
					Visitors that are signed out will automatically be assigned to this group
				{elseif $group.id == $playerId}
					Visitors that are signed in will automatically be assigned to this group
				{else}
					{if $members}
						{foreach from=$members item=member}
							<a href="javascript:void(0)" onClick="Groups.removeAccount('{$member.username}', this, {$group.id} {if $member.username == $CI->user->getUsername()}, true{/if})">
								<img src="{$url}application/images/icons/delete.png" />
								{ucfirst($member.username)}
							</a>
						{/foreach}
					{/if}

					<a href="javascript:void(0)" onClick="Groups.addAccount(this, {$group.id})" class="add">
						<img src="{$url}application/images/icons/add.png" />Add
					</a>
					<div class="clear"></div>
				{/if}
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
									<td width="5%" style="text-align:center;"><input type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}" {if $link.has}checked="checked"{/if}></td>
									<td width="25%">
										<span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span>

										<label for="MENU_{$link.id}" style="display:inline;border:none;font-weight:bold;">{langColumn($link.name)}</label></td>
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
									<td width="5%" style="text-align:center;"><input type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}" {if $page.has}checked="checked"{/if}></td>
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
									<td width="5%" style="text-align:center;"><input type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}" {if $sidebox.has}checked="checked"{/if}></td>
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
									<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}" {if $role.has}checked="checked"{/if}></td>
									<td width="25%">Custom role: <label for="{$name}-{$role.name}" style="	display:inline;border:none;font-weight:bold;">{$role.name}</label></td>
									<td style="font-size:10px;">{$role.description}</td>
								</tr>
							{/foreach}
						{/if}
						
						{if $module.manifest}
							{foreach from=$module.manifest key=roleName item=role}
								<tr>
									<td width="5%" style="text-align:center;"><input type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}" {if $role.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="{$name}-{$roleName}" style="display:inline;border:none;font-weight:bold;{if isset($role.color)}color:{$role.color};{/if}">
											{$roleName}
										</label>
									</td>
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
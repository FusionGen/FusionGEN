<div class="card mb-3">
	<div class="card-header">Edit group</div>

	<div class="card-body">
	<form role="form" onSubmit="Groups.save(this, {$group.id}); return false" id="submit_form">
		
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Group name</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="name" id="name" value="{$group.name}">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (optional)</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="description" id="description" value="{$group.description}">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="color">Group color (optional)</label>
		<div class="col-sm-10">
			<input type="color" name="color" id="color" value="{$group.color}" style="padding:0;">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="members">Members</label>
		<div class="col-sm-10">
		<span>
			<div class="mb-3">
				{if $group.id == $guestId}
					Visitors that are signed out will automatically be assigned to this group
				{elseif $group.id == $playerId}
					Visitors that are signed in will automatically be assigned to this group
				{else}
					{if $members}
						{foreach from=$members item=member}
							<a class="btn btn-default btn-sm" href="javascript:void(0)" onClick="Groups.removeAccount('{$member.username}', this, {$group.id} {if $member.username == $CI->user->getUsername()}, true{/if})">
								{ucfirst($member.username)}
							</a>
						{/foreach}
					{/if}

					<a href="javascript:void(0)" onClick="Groups.addAccount(this, {$group.id})" class="btn btn-success btn-sm add">
						Add
					</a>
					<div class="clear"></div>
				{/if}
			</div>
		</span>
		</div>
        </div>

		<label class="col-sm-3 col-form-label" for="roles">
			<a href="javascript:void(0)" onClick="$('#visibility input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Visibility permissions
		</label>

		<div id="visibility">
			{if $links}
				<div class="role_module">
					<h3>Menu links</h3>
					<table class="table table-responsive-md table-hover">
					{foreach from=$links item=link}
						<tbody style="border-top:none;">
							{if $link.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}" {if $link.has}checked="checked"{/if}></td>
									<td width="25%">
										<span>{$link.side}&nbsp;&nbsp;</span>

										<label for="MENU_{$link.id}">{langColumn($link.name)}</label></td>
									<td>{$link.link}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This menu link is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Menu links' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<span>{$link.side}&nbsp;&nbsp;</span>

										<label>{langColumn($link.name)}</label></td>
									<td>{$link.link}</td>
								</tr>
							{/if}
						</tbody>							
					{/foreach}
					</table>
				</div>
			{/if}

			{if $pages}
				<div class="role_module">
					<h3>Custom pages</h3>
					<table class="table table-responsive-md table-hover">
					{foreach from=$pages item=page}
						<tbody style="border-top:none;">
							{if $page.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}" {if $page.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="PAGE_{$page.id}">{langColumn($page.name)}</label></td>
									<td>pages/{$page.identifier}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This page is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Custom pages' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}">{langColumn($page.name)}</label></td>
									<td>pages/{$page.identifier}</td>
								</tr>
							{/if}
						</tbody>
					{/foreach}
					</table>
				</div>
			{/if}

			{if $sideboxes}
				<div class="role_module">
					<h3>Sideboxes</h3>
					{foreach from=$sideboxes item=sidebox}
						<table class="table table-responsive-md table-hover mb-0">
						<tbody style="border-top:none;">
							{if $sidebox.permission}
								<tr>
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}" {if $sidebox.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{else}
								<tr style="opacity:0.6" data-toggle="tooltip" data-placement="bottom" title="This sidebox is set to 'Visible to everyone'-mode.<br />If you want to control the visibility per group, please<br /> go to 'Sideboxes' and change the visibility mode.">
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{/if}
						</table>
						</table>
					{/foreach}
				</div>
			{/if}
		</div>
		
		<label for="roles" data-toggle="tooltip" data-placement="bottom" title="A role is a pre-defined set of permissions. The color indicates the role's danger-level. Please note that certain permissions may have a default value of 'allowed', such as actions that are meant to be performed by everyone by default.">
			<a href="javascript:void(0)" onClick="$('#roles input[type=checkbox]').each(function(){ this.checked = true; });" style="float:right;display:block;">[Select all]</a>
			Roles <a>(?)</a>
		</label>
		<div id="roles">
		{foreach from=$modules key=name item=module}
			{if $module.db || $module.manifest}
				<div class="role_module">
					<h3>{ucfirst($module.name)}</h3>
					<table class="table table-responsive-md table-hover">
					<tbody style="border-top:none;">
						{if $module.db}
							{foreach from=$module.db item=role}
								<tr>
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}" {if $role.has}checked="checked"{/if}></td>
									<td width="25%">Custom role: <label for="{$name}-{$role.name}" style="display:inline;border:none;font-weight:bold;">{$role.name}</label></td>
									<td style="font-size:10px;">{$role.description}</td>
								</tr>
							{/foreach}
						{/if}
						
						{if $module.manifest}
							{foreach from=$module.manifest key=roleName item=role}
								<tr>
									<td width="5%" style="text-align:center;"><input class="form-check-input" type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}" {if $role.has}checked="checked"{/if}></td>
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
					</table>
				</div>
			{/if}
		{/foreach}
		</div>
	</ul>
	</div>
	</div>
		<button type="submit" class="btn btn-primary btn-sm">Submit group</button>
	</form>
</section>
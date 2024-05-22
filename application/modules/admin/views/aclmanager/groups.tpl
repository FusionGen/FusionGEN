<section class="card" id="main_groups">
	<div class="card-header">
		Groups (<div class="d-inline" id="groups_count">{if !$groups}0{else}{count($groups)}{/if}</div>){if hasPermission("addPermissions")}<a class="btn btn-primary btn-sm pull-right" href="javascript:void(0)" onClick="Groups.add()">Create group</a>{/if}
	</div>

	<div class="card-body table-responsive">
		{if $groups}
		<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>ID</th>
				<th>Members</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$groups item=group}
				<tr>
					<td class="fw-bold" data-toggle="tooltip" data-placement="bottom" title="{$group.description}" style="color:{$group.color} !important;">{$group.name}</td>
					<td> {$group.id}</td>
					<td>{if $group.memberCount}{$group.memberCount} {($group.memberCount == 1) ? "member" : "members"}{/if}</td>
					<td class="text-center">
						{if hasPermission("editPermissions")}
							<a class="btn btn-primary btn-sm" href="{$url}admin/aclmanager/editGroup/{$group.id}">Edit</a>
						{/if}

						{if hasPermission("deletePermissions")}
							{if !in_array($group.id, array($guestId, $playerId))}
							<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Groups.remove({$group.id}, this)">Delete</a>
							{/if}
						{/if}
					</td>
				</tr>
			{/foreach}
		</tbody>
		</table>
		{/if}
	</div>
</section>

<section class="card" id="add_groups" style="display:none;">
	<div class="card-header">
	<a href='javascript:void(0)' onClick="Groups.add()" data-toggle="tooltip" data-placement="bottom" title="Return to groups">Groups</a> &rarr; New group
	</div>
	<div class="card-body">
	<form onSubmit="Groups.create(this); return false" id="submit_form">
	
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="name">Group name</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" name="name" id="name">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="description">Description (optional)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" name="description" id="description">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="color">Group color (optional)</label>
		<div class="col-sm-10">
		<input type="color" name="color" id="color" value="#ffffff">
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="members">Members</label>
		<div class="col-sm-10">
		<span>
			<div class="memberList">
				Members can be added once the group has been created
			</div>
		</span>
		</div>
        </div>

		<label class="col-sm-4 col-form-label mt-3" for="visibility">
			<a href="javascript:void(0)" onClick="$('#visibility input[type=checkbox]').each(function(){ this.checked = true; });" class="float-end d-block ms-2">[Select all]</a>
			Visibility permissions
		</label>

		<div id="visibility">
			{if $links}
				<div class="role_module table-responsive">
					<h3>Menu links</h3>
					{foreach from=$links item=link}
						<table class="table table-hover">
							{if $link.permission}
								<tr>
									<td width="5%" class="text-center"><input type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}"></td>
									<td width="25%">
										<span class="p-0 d-inline me-1"><small>{$link.side}</small></span>

										<label for="MENU_{$link.id}" class="d-inline border-0 fw-bold">{langColumn($link.name)}</label></td>
									<td>{$link.link}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This menu link is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Menu links' and change the visibility mode.">
									<td width="5%" class="text-center"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<span class="p-0 d-inline me-1"><small>{$link.side}</small></span>

										<label class="d-inline border-0 fw-bold">{langColumn($link.name)}</label></td>
									<td>{$link.link}</td>
								</tr>
							{/if}
						</table>
					{/foreach}
				</div>
			{/if}

			{if $pages}
				<div class="role_module table-responsive">
					<h3>Custom pages</h3>
					{foreach from=$pages item=page}
						<table class="table table-hover">
							{if $page.permission}
								<tr>
									<td width="5%" class="text-center"><input type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" class="d-inline border-0 fw-bold">{langColumn($page.name)}</label></td>
									<td>pages/{$page.identifier}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This page is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Custom pages' and change the visibility mode.">
									<td width="5%" class="text-center"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" class="d-inline border-0 fw-bold">{langColumn($page.name)}</label></td>
									<td>pages/{$page.identifier}</td>
								</tr>
							{/if}
						</table>
					{/foreach}
				</div>
			{/if}

			{if $sideboxes}
				<div class="role_module table-responsive">
					<h3>Sideboxes</h3>
					{foreach from=$sideboxes item=sidebox}
						<table class="table table-hover">
							{if $sidebox.permission}
								<tr>
									<td width="5%" class="text-center"><input type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" class="d-inline border-0 fw-bold">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This sidebox is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Sideboxes' and change the visibility mode.">
									<td width="5%" class="text-center"><input type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" class="d-inline border-0 fw-bold">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{/if}
						</table>
					{/foreach}
				</div>
			{/if}
		</div>

		<label class="col-sm-4 col-form-label mt-3" for="roles" data-toggle="tooltip" data-placement="bottom" title="A role is a pre-defined set of permissions. The color indicates the role's danger-level. Please note that certain permissions may have a default value of 'allowed', such as actions that are meant to be performed by everyone by default.">
			<a href="javascript:void(0)" onClick="$('#roles input[type=checkbox]').each(function(){ this.checked = true; });" class="float-end d-block ms-2">[Select all]</a>
			Roles <a>(?)</a>
		</label>

		<div id="roles">
			{foreach from=$modules key=name item=module}
				{if $module.db || $module.manifest}
					<div class="role_module table-responsive">
						<h3>{ucfirst($module.name)}</h3>
						<table class="table table-hover">
							{if $module.db}
								{foreach from=$module.db item=role}
									<tr>
										<td width="5%" class="text-center"><input type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}"></td>
										<td width="25%">Custom role: <label for="{$name}-{$role.name}" class="d-inline border-0 fw-bold">{$role.name}</label></td>
										<td>{$role.description}</td>
									</tr>
								{/foreach}
							{/if}

							{if $module.manifest}
								{foreach from=$module.manifest key=roleName item=role}
									<tr>
										<td width="5%" class="text-center"><input type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}"></td>
										<td width="25%"><label for="{$name}-{$roleName}" class="d-inline border-0 fw-bold" style="{if isset($role.color)}color:{$role.color};{/if}">{$roleName}</label></td>
										<td>{$role.description}</td>
									</tr>
								{/foreach}
							{/if}
						</table>
					</div>
				{/if}
			{/foreach}
		</div>

		<button type="submit" class="btn btn-primary btn-sm">Submit group</button>
	</form>
	</div>
</div>

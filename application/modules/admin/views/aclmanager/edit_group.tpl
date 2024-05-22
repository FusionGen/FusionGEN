<div class="card mb-3">
	<div class="card-header">Edit group</div>

	<div class="card-body table-responsive">
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
			<input type="color" name="color" id="color" value="{$group.color}" class="p-0">
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

		<label class="col-sm-4 col-form-label mt-3" for="visibility">
			<a href="javascript:void(0)" onClick="$('#visibility input[type=checkbox]').each(function(){ this.checked = true; });" class="float-end d-block ms-2">[Select all]</a>
			Visibility permissions
		</label>

		<div id="visibility">
			{if $links}
				<div class="role_module">
					<h3>Menu links</h3>
					<table class="table table-hover">
					{foreach from=$links item=link}
						<tbody class="border-0">
							{if $link.permission}
								<tr>
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" name="MENU_{$link.id}" id="MENU_{$link.id}" {if $link.has}checked="checked"{/if}></td>
									<td width="25%">
										<span class="p-0 d-inline me-1"><small>{$link.side}</small></span>

										<label for="MENU_{$link.id}" class="d-inline border-0 fw-bold">{langColumn($link.name)}</label></td>
									<td>{$link.link}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This menu link is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Menu links' and change the visibility mode.">
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<span class="p-0 d-inline me-1"><small>{$link.side}</small></span>

										<label class="d-inline border-0 fw-bold">{langColumn($link.name)}</label></td>
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
					<table class="table table-hover">
					{foreach from=$pages item=page}
						<tbody class="border-0">
							{if $page.permission}
								<tr>
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" name="PAGE_{$page.id}" id="PAGE_{$page.id}" {if $page.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" class="d-inline border-0 fw-bold">{langColumn($page.name)}</label></td>
									<td>pages/{$page.identifier}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This page is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Custom pages' and change the visibility mode.">
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="PAGE_{$page.id}" class="d-inline border-0 fw-bold">{langColumn($page.name)}</label></td>
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
						<table class="table table-hover mb-0">
						<tbody class="border-0">
							{if $sidebox.permission}
								<tr>
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" name="SIDEBOX_{$sidebox.id}" id="SIDEBOX_{$sidebox.id}" {if $sidebox.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" class="d-inline border-0 fw-bold">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{else}
								<tr data-toggle="tooltip" data-placement="bottom" title="This sidebox is set to 'Visible to everyone'-mode.&#013;If you want to control the visibility per group, please go to 'Sideboxes' and change the visibility mode.">
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" disabled="disabled" checked="checked"></td>
									<td width="25%">
										<label for="SIDEBOX_{$sidebox.id}" class="d-inline border-0 fw-bold">{langColumn($sidebox.displayName)}</label></td>
									<td>{$sidebox.type}</td>
								</tr>
							{/if}
						</table>
						</table>
					{/foreach}
				</div>
			{/if}
		</div>

		<label class="col-sm-4 col-form-label mt-3" for="roles" data-toggle="tooltip" data-placement="bottom" title="A role is a pre-defined set of permissions. The color indicates the role's danger-level.&#013;Please note that certain permissions may have a default value of 'allowed', such as actions that are meant to be performed by everyone by default.">
			<a href="javascript:void(0)" onClick="$('#roles input[type=checkbox]').each(function(){ this.checked = true; });" class="float-end d-block ms-2">[Select all]</a>
			Roles <a>(?)</a>
		</label>
		<div id="roles">
		{foreach from=$modules key=name item=module}
			{if $module.db || $module.manifest}
				<div class="role_module">
					<h3>{ucfirst($module.name)}</h3>
					<table class="table table-hover">
					<tbody class="border-0">
						{if $module.db}
							{foreach from=$module.db item=role}
								<tr>
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" name="{$name}-{$role.name}" id="{$name}-{$role.name}" {if $role.has}checked="checked"{/if}></td>
									<td width="25%">Custom role: <label for="{$name}-{$role.name}" class="d-inline border-0 fw-bold">{$role.name}</label></td>
									<td>{$role.description}</td>
								</tr>
							{/foreach}
						{/if}

						{if $module.manifest}
							{foreach from=$module.manifest key=roleName item=role}
								<tr>
									<td width="5%" class="text-center"><input class="form-check-input" type="checkbox" name="{$name}-{$roleName}" id="{$name}-{$roleName}" {if $role.has}checked="checked"{/if}></td>
									<td width="25%">
										<label for="{$name}-{$roleName}" class="d-inline border-0 fw-bold" style="{if isset($role.color)}color:{$role.color};{/if}">
											{$roleName}
										</label>
									</td>
									<td>{$role.description}</td>
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

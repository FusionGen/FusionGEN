<div class="row">
<div class="col-lg-4">
<div id="card">
	<div class="card-body">
		<div class="widget-profile-info">
			<div class="profile-picture">
				<img class="avatar" src="{$url}application/images/avatars/{$avatar}.gif"/>
			</div>
			<div class="profile-info">
				<h4 class="name font-weight-semibold"><a href="{$url}character/{$realmId}/{$tickets.guid}" target="_blank">{$tickets.name}</a></h4>
				<h5 class="role color-c{$class}"><b>{$level}</b> {$raceName} {$className}</h5>
				<div class="profile-footer">
					<a href="#">{if !$status}Offline{else}Online{/if}</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="col-lg-8">
<div id="card">
	<div class="card-body">
	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="side">Ticket</label>
	<div class="col-lg-9 align-self-center">
		#{$tickets.ticketId}
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="side">Account</label>
	<div class="col-lg-9 align-self-center">
		<a href="{$url}profile/{$account}" target="_blank">{$CI->user->getUsername({$account})}</a>
	</div>
	</div>
	
	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="side">Name</label>
	<div class="col-lg-9 align-self-center">
		<a href="{$url}character/{$realmId}/{$tickets.guid}" target="_blank">{$tickets.name}</a>
	</div>
	</div>

	<div class="form-group row">
	<label class="col-lg-3 col-form-label form-control-label" for="side">Time</label>
	<div class="col-lg-9 align-self-center">
		{date("Y/m/d H:i:s", $tickets.createTime)}
	</div>
	</div>
	
	<div class="form-group row mb-3">
	<label class="col-lg-3 col-form-label form-control-label" for="side">Message</label>
	<div class="col-lg-9 align-self-center">
		{$tickets.message}
	</div>
	</div>
	
	<a href="javascript:void(0)" onClick="Mod.close({$realmId}, {$tickets.ticketId}, this)" class="btn btn-sm btn-primary"><img src="{$url}application/images/icons/accept.png" align="absmiddle"> Close</a>

	<a href="javascript:void(0)" onClick="Mod.answer({$realmId}, {$tickets.ticketId}, this)" class="btn btn-sm btn-primary"><img src="{$url}application/images/icons/email.png" align="absmiddle"> Answer</a>

	<a href="javascript:void(0)" onClick="Mod.unstuck({$realmId}, {$tickets.ticketId}, this)" class="btn btn-sm btn-primary"><img src="{$url}application/images/icons/wand.png" align="absmiddle"> Unstuck</a>
	</div>
</div>
</div>
</div>
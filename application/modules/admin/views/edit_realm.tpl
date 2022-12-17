<div class="card">
	<header class="card-header">Realm settings</div>

	<form onSubmit="Settings.saveRealm({$realm->getId()}); return false">
		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realmName">Realm name</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="realmName" name="realmName" value="{$realm->getName()}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="realmName">Hostname / IP (to your emulator server)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="hostname" value="{$realm->getConfig('hostname')}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_hostname_char">Characters: database hostname</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_hostname_char" value="{$hostname_char}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_username_char">Characters: database username</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_username_char" value="{$username_char}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_password_char">Characters: database password</label>
		<div class="col-sm-10">
		<input class="form-control" type="password" id="override_password_char" value="{$password_char}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_port_char">Characters: database port</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_port_char" value="{$port_char}"  />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_hostname_world">World: database hostname</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_hostname_world" value="{$hostname_world}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_username_world">World: database username</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_username_world" value="{$username_world}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_password_world">World: database password</label>
		<div class="col-sm-10">
		<input class="form-control" type="password" id="override_password_world" value="{$password_world}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="override_port_world">World: database port</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="override_port_world" value="{$port_world}"  />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="characters">Characters database</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="characters" name="characters" value="{$realm->getConfig('characters_database')}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="world">World database</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="world" name="world" value="{$realm->getConfig('world_database')}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="cap">Max allowed players online</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="cap" name="cap" value="{$realm->getCap()}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="port">Realm port (usually 8129)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="port" name="port" value="{$realm->getConfig('realm_port')}" />
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="emulator">Emulator</label>
		<div class="col-sm-10">
		<select class="form-control" id="emulator" name="emulator">
			{foreach from=$emulators key=emu_id item=emu_name}
			<option value="{$emu_id}" {if $emu_id == $realm->getConfig('emulator')}selected{/if}>{$emu_name}</option>
			{/foreach}
		</select>
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="console_port">Console port (only required for emulators that use remote console systems; usually 3443 for RA and 7878 for SOAP)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="console_port" name="console_port" value="{$realm->getConfig('console_port')}"/>
		</div>
        </div>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="console_username" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="console_username" name="console_username" value="{$realm->getConfig('console_username')}" />
		</div>
        </div>

		<div class="form-group row mb-3">
		<label class="col-sm-2 col-form-label" for="console_password" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
		<div class="col-sm-10">
		<input class="form-control" type="text" id="console_password" name="console_password" placeholder="Enter a new password if you want to change it" />
		</div>
        </div>

		<button class="btn btn-primary btn-sm" type="submit">Save realm</button>
	</form>
</div>
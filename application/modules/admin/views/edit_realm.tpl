<section class="box big">
	<h2><img src="{$url}application/themes/admin/images/icons/black16x16/ic_settings.png"/> Realm settings</h2>

	<form onSubmit="Settings.saveRealm({$realm->getId()}); return false">
		<label for="realmName">Realm name</label>
		<input type="text" id="realmName" name="realmName" value="{$realm->getName()}" />

		<label for="realmName">Hostname / IP (to your emulator server)</label>
		<input type="text" id="hostname" value="{$realm->getConfig('hostname')}" />

		<label for="override_hostname_char">Characters: database hostname</label>
		<input type="text" id="override_hostname_char" value="{$hostname_char}" />

		<label for="override_username_char">Characters: database username</label>
		<input type="text" id="override_username_char" value="{$username_char}" />

		<label for="override_password_char">Characters: database password</label>
		<input type="password" id="override_password_char" value="{$password_char}" />

		<label for="override_port_char">Characters: database port</label>
		<input type="text" id="override_port_char" value="{$port_char}"  />

		<label for="override_hostname_world">World: database hostname</label>
		<input type="text" id="override_hostname_world" value="{$hostname_world}" />

		<label for="override_username_world">World: database username</label>
		<input type="text" id="override_username_world" value="{$username_world}" />

		<label for="override_password_world">World: database password</label>
		<input type="password" id="override_password_world" value="{$password_world}" />

		<label for="override_port_world">World: database port</label>
		<input type="text" id="override_port_world" value="{$port_world}"  />

		<label for="characters">Characters database</label>
		<input type="text" id="characters" name="characters" value="{$realm->getConfig('characters_database')}" />

		<label for="world">World database</label>
		<input type="text" id="world" name="world" value="{$realm->getConfig('world_database')}" />

		<label for="cap">Max allowed players online</label>
		<input type="text" id="cap" name="cap" value="{$realm->getCap()}" />

		<label for="port">Realm port (usually 8129)</label>
		<input type="text" id="port" name="port" value="{$realm->getConfig('realm_port')}" />


		<label for="emulator">Emulator</label>
		<select id="emulator" name="emulator">
			{foreach from=$emulators key=emu_id item=emu_name}
			<option value="{$emu_id}" {if $emu_id == $realm->getConfig('emulator')}selected{/if}>{$emu_name}</option>
			{/foreach}
		</select>

		<label for="console_port">Console port (only required for emulators that use remote console systems; usually 3443 for RA and 7878 for SOAP)</label>
		<input type="text" id="console_port" name="console_port" value="{$realm->getConfig('console_port')}"/>

		<label for="console_username" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
		<input type="text" id="console_username" name="console_username" value="{$realm->getConfig('console_username')}" />

		<label for="console_password" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
		<input type="text" id="console_password" name="console_password" placeholder="Enter a new password if you want to change it" />

		<input type="submit" value="Save realm" />
	</form>
</section>
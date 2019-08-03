<section class="box big" id="realm_settings">
	<h2><img src="{$url}application/themes/admin/images/icons/black16x16/ic_cloud.png"/> Realms (<div style="display:inline;" id="realm_count">{count($realms)}</div>)</h2>
	<span>
		<div style="float:right;" data-tip="The logon emulator is the emulator of the first realm"><b>Logon/realmd/auth emulator:</b> {if $realms}{strtoupper($realms[0]->getConfig("emulator"))}{/if}</div>
		<a class="nice_button" href="javascript:void(0)" onClick="Settings.showAddRealm()">Add a new realm</a>
	</span>
	<ul id="realm_list">
		{foreach from=$realms item=realm}
			<li>
				<table width="100%">
					<tr>
						<td width="10%">ID: {$realm->getId()}</td>
						<td width="30%"><b>{$realm->getName()}</b></td>
						<td width="30%">{$realm->getConfig("hostname")}</td>
						<td width="20%">{strtoupper($realm->getConfig("emulator"))}</td>
						<td style="text-align:right;">
							<a href="{$url}admin/realmmanager/edit/{$realm->getId()}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
							<a href="javascript:void(0)" onClick="Settings.remove({$realm->getId()}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
						</td>
					</tr>
				</table>
			</li>
		{/foreach}
	</ul>
</section>

<div id="add_realm" style="display:none;">
	<section class="box big">
		<h2><a href='javascript:void(0)' onClick="Settings.showAddRealm()" data-tip="Return to settings">Settings</a> &rarr; New realm</h2>

		<form onSubmit="Settings.addRealm(); return false">
			<label for="realmName">Realm name</label>
			<input type="text" id="realmName" />

			<label for="realmName">Hostname / IP (to your emulator server)</label>
			<input type="text" id="hostname" />

			<label>Server structure (mainly for the bigger private servers with clustered hosts)</label>
			<select id="server_structure" onChange="Settings.changeStructure(this)">
				<option value="1" selected>[All in one] I host emulator and both characters and world databases on the same server (default)</option>
				<option value="2">[Emulator and databases separated] I host the emulator on one server and the databases on another</option>
				<option value="3">[All separate] I host emulator, world and characters on three different servers</option>
			</select>

			<div id="one">
				<label for="username">Database username</label>
				<input type="text" id="username" />

				<label for="password">Database password</label>
				<input type="password" id="password" />
			</div>

			<div id="two" style="display:none;">
				<label for="override_hostname_char">Characters &amp; world: database hostname</label>
				<input type="text" id="override_hostname_char" />

				<label for="override_username_char">Characters &amp; world: database username</label>
				<input type="text" id="override_username_char" />

				<label for="override_password_char">Characters &amp; world: database password</label>
				<input type="password" id="override_password_char" />

				<label for="override_port_char">Characters &amp; world: database port</label>
				<input type="text" id="override_port_char" value="3306" />
			</div>

			<div id="three" style="display:none;">
				<label for="override_hostname_char_three">Characters: database hostname</label>
				<input type="text" id="override_hostname_char_three" />

				<label for="override_username_char_three">Characters: database username</label>
				<input type="text" id="override_username_char_three" />

				<label for="override_password_char_three">Characters: database password</label>
				<input type="password" id="override_password_char_three" />

				<label for="override_port_char_three">Characters: database port</label>
				<input type="text" id="override_port_char_three" value="3306" />

				<label for="override_hostname_world_three">World: database hostname</label>
				<input type="text" id="override_hostname_world_three" />

				<label for="override_username_world_three">World: database username</label>
				<input type="text" id="override_username_world_three" />

				<label for="override_password_world_three">World: database password</label>
				<input type="password" id="override_password_world_three" />

				<label for="override_port_world_three">World: database port</label>
				<input type="text" id="override_port_world_three" value="3306" />
			</div>

			<label for="characters">Characters database</label>
			<input type="text" id="characters"/>

			<label for="world">World database</label>
			<input type="text" id="world" />

			<label for="cap">Max allowed players online</label>
			<input type="text" id="cap" />

			<label for="port">Realm port (usually 8085 for Trinity/MaNGoS based emulators and 8129 for ArcEmu)</label>
			<input type="text" id="port" />


			<label for="emulator">Emulator</label>
			<select id="emulator">
				{foreach from=$emulators key=emu_id item=emu_name}
					<option value="{$emu_id}">{$emu_name}</option>
				{/foreach}
			</select>

			<label for="console_port">Console port (only required for emulators that use RA or SOAP; usually 3443 for RA and 7878 for SOAP)</label>
			<input type="text" id="console_port" />

			<label for="console_username" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
			<input type="text" id="console_username" />

			<label for="console_password" data-tip="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
			<input type="password" id="console_password" />

			<input type="submit" value="Add realm" />
		</form>
	</section>
</div>

<div id="non_realm">
	<section class="box big">
		<h2><img src="{$url}application/themes/admin/images/icons/black16x16/ic_settings.png"/> Website</h2>
		
		<form onSubmit="Settings.saveWebsiteSettings(); return false">
			<label for="title">Website title</label>
			<input type="text" id="title" placeholder="MyServer" value="{$config.title}" />

			<label for="server_name">Server name</label>
			<input type="text" id="server_name" placeholder="MyServer" value="{$config.server_name}" />

			<label for="realmlist">Realmlist</label>
			<input type="text" id="realmlist" placeholder="logon.myserver.com" value="{$config.realmlist}" />

			<label for="disabled_expansions">Max expansion</label>
			<select id="disabled_expansions">
				<option value="bfa" 	{if count($config.disabled_expansions) == 0}selected{/if}>Battle for Azeroth</option>
				<option value="legion-ar" {if count($config.disabled_expansions) == 1}selected{/if}>Legion Allied Races</option>
				<option value="legion" 				{if count($config.disabled_expansions) == 2}selected{/if}>Legion</option>
				<option value="wod" 				{if count($config.disabled_expansions) == 3}selected{/if}>Warlords of Draenor</option>
				<option value="mop" 				{if count($config.disabled_expansions) == 4}selected{/if}>Mists Of Pandaria</option>
				<option value="cata" 				{if count($config.disabled_expansions) == 5}selected{/if}>Cataclysm</option>
				<option value="wotlk" 				{if count($config.disabled_expansions) == 6}selected{/if}>Wrath of the Lich King</option>
				<option value="tbc" 				{if count($config.disabled_expansions) == 7}selected{/if}>The Burning Crusade</option>
				<option value="none" 				{if count($config.disabled_expansions) == 8}selected{/if}>No expansion allowed</option>
			</select>

			<label for="keywords">Search engine: keywords (separated by comma)</label>
			<input type="text" id="keywords" placeholder="world of warcraft,wow,private server,pvp" value="{$config.keywords}" />

			<label for="description">Search engine: description</label>
			<input type="text" id="description" placeholder="Best World of Warcraft private server in the entire world!" value="{$config.description}" />

			<label for="analytics"><a href="http://analytics.google.com" target="_blank">Google Analytics</a> website ID for advanced statistics (optional)</label>
			<input type="text" id="analytics" placeholder="XX-YYYYYYYY-Z" value="{$config.analytics}"/>

			<label for="vote_reminder">Enable vote reminder popup</label>
			<select id="vote_reminder" onChange="Settings.toggleVoteReminder(this)">
				<option value="1" {if $config.vote_reminder}selected{/if}>Yes</option>
				<option value="0" {if !$config.vote_reminder}selected{/if}>No</option>
			</select>

			<div id="vote_reminder_settings" {if !$config.vote_reminder}style="display:none;"{/if}>
				<label for="vote_reminder_image">Vote reminder image URL</label>
				<input type="text" id="vote_reminder_image" placeholder="http://mywebsite.com/images/banner.gif" value="{$config.vote_reminder_image}"/>

				<label for="reminder_interval">Vote reminder interval (in hours)</label>
				<input type="text" id="reminder_interval" value="{$config.reminder_interval/60/24}" placeholder="12" />
			</div>

			<label for="cdn">Use content delivery network for Javascript libraries (do only disable it for LAN-only environments)</label>
			<select id="cdn">
				<option value="1" {if $config.cdn}selected{/if}>Yes</option>
				<option value="0" {if !$config.cdn}selected{/if}>No</option>
			</select>

			<label for="has_smtp">Enable password recovery (requires SMTP server)</label>
			<select id="has_smtp">
				<option value="1" {if $config.has_smtp}selected{/if}>Yes</option>
				<option value="0" {if !$config.has_smtp}selected{/if}>No</option>
			</select>


			<input type="submit" value="Save settings" />

			<center id="website_ajax"></center>
		</form>
	</section>

	<section class="box big">
		<h2><img src="{$url}application/themes/admin/images/icons/black16x16/ic_settings.png"/> SMTP mail settings</h2>
		
		<form onSubmit="Settings.saveSmtpSettings(); return false">
			<label for="use_own_smtp_settings">Use own SMTP settings (enter them below)</label>
			<select id="use_own_smtp_settings">
				<option value="1" {if $smtp.use_own_smtp_settings}selected{/if}>Yes</option>
				<option value="0" {if !$smtp.use_own_smtp_settings}selected{/if}>No</option>
			</select>

			<label for="smtp_host">SMTP hostname</label>
			<input type="text" id="smtp_host" value="{$smtp.smtp_host}" />

			<label for="smtp_user">SMTP username</label>
			<input type="text" id="smtp_user" value="{$smtp.smtp_user}" />

			<label for="smtp_pass">SMTP password</label>
			<input type="text" id="smtp_pass" value="{$smtp.smtp_pass}" />

			<label for="smtp_port">SMTP port</label>
			<input type="text" id="smtp_port" value="{$smtp.smtp_port}" />

			<input type="submit" value="Save settings" />

			<center id="smtp_ajax"></center>
		</form>
	</section>

	<section class="box big">
		<h2><img src="{$url}application/themes/admin/images/icons/black16x16/ic_power.png"/> Performance settings</h2>
		
		<form onSubmit="Settings.savePerformanceSettings(); return false">

			<label for="disable_visitor_graph" data-tip="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Disable dashboard visitor graph <a>(?)</a></label>
			<select name="disable_visitor_graph" id="disable_visitor_graph">
				<option value="1" {if $config.disable_visitor_graph}selected{/if}>Yes</option>
				<option value="0" {if !$config.disable_visitor_graph}selected{/if}>No</option>
			</select>

			<input type="submit" value="Save settings" />

			<center id="performance_ajax"></center>
		</form>
	</section>
</div>
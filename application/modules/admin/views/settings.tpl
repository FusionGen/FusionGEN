<div class="row" id="non_realm">
<div class="tabs">
    <ul class="nav nav-tabs">
	    <li class="nav-item">
			<a class="nav-link active" href="#realms" data-bs-target="#realms" data-bs-toggle="tab">Realms</a>
        </li>
        <li class="nav-item">
			<a class="nav-link" href="#website" data-bs-target="#website" data-bs-toggle="tab">Website</a>
        </li>
        <li class="nav-item">
			<a class="nav-link" href="#smtp" data-bs-target="#smtp" data-bs-toggle="tab">SMTP</a>
        </li>
        <li class="nav-item">
			<a class="nav-link" href="#performance" data-bs-target="#performance" data-bs-toggle="tab">Performance</a>
        </li>
		<li class="nav-item">
			<a class="nav-link" href="#social_media" data-bs-target="#social_media" data-bs-toggle="tab">Social Media</a>
        </li>
		<li class="nav-item">
			<a class="nav-link" href="#cdn" data-bs-target="#cdn" data-bs-toggle="tab">CDN</a>
        </li>
		<li class="nav-item">
			<button onClick="Settings.showHelp()" type="button" class="btn btn-primary"><i class="fa-solid fa-circle-info fa-lg"></i></button>
        </li>
    </ul>

    <div class="tab-content">
	    <div class="tab-pane active" id="realms">
			<section class="card" id="realm_settings">
			<header class="card-header">Realms (<div style="display:inline;" id="realm_count">{count($realms)}</div>)
			<button class="btn btn-primary btn-sm pull-right" href="javascript:void(0)" onClick="Settings.showAddRealm()">Add a new realm</button>
			</header>
			<div class="card-body">
			<table class="table table-responsive-md table-hover mb-0">
			<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Host</th>
				<th>Emulator</th>
				<th style="text-align: center;">Actions</th>
			</tr>
			</thead>
			<tbody>
				{foreach from=$realms item=realm}
						<tr>
							<td>ID: {$realm->getId()}</td>
							<td><b>{$realm->getName()}</b></td>
							<td>{$realm->getConfig("hostname")}</td>
							<td>{strtoupper($realm->getConfig("emulator"))}</td>
							<td style="text-align: center;">
								<a class="btn btn-primary btn-sm" href="{$url}admin/realmmanager/edit/{$realm->getId()}">Edit</a>&nbsp;
								<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Settings.remove({$realm->getId()}, this)">Delete</a>
							</td>
						</tr>
				{/foreach}
			</tbody>
			</table>
			</div>
			<div class="card-footer">
			<div data-toggle="tooltip" data-placement="bottom" title="The logon emulator is the emulator of the first realm"><b>Logon/realmd/auth emulator:</b> {if $realms}{strtoupper($realms[0]->getConfig("emulator"))}{/if}</div>
			</div>
			</section>
			
			<div class="card" id="add_realm" style="display:none;">
			<header class="card-header">New realm</header>
	
			<div class="col-sm-12">
			<form role="form" onSubmit="Settings.addRealm(); return false">
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="realmName">Realm name</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="realmName" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="realmName">Hostname / IP (to your emulator server)</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="hostname" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label">Server structure (mainly for the bigger private servers with clustered hosts)</label>
				<div class="col-sm-10">
				<select class="form-control" id="server_structure" onChange="Settings.changeStructure(this)">
					<option value="1" selected>[All in one] I host emulator and both characters and world databases on the same server (default)</option>
					<option value="2">[Emulator and databases separated] I host the emulator on one server and the databases on another</option>
					<option value="3">[All separate] I host emulator, world and characters on three different servers</option>
				</select>
				</div>
				</div>
	
				<div id="one">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="username">Database username</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="username" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="password">Database password</label>
					<div class="col-sm-10">
					<input class="form-control" type="password" id="password" />
					</div>
					</div>
				</div>
	
				<div id="two" style="display:none;">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_char">Characters &amp; world: database hostname</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" id="override_hostname_char" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char">Characters &amp; world: database username</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" id="override_username_char" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char">Characters &amp; world: database password</label>
					<div class="col-sm-10">
						<input class="form-control" type="password" id="override_password_char" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char">Characters &amp; world: database port</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" id="override_port_char" value="3306" />
					</div>
					</div>
				</div>
	
				<div id="three" style="display:none;">
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_char_three">Characters: database hostname</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_hostname_char_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_char_three">Characters: database username</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_username_char_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_char_three">Characters: database password</label>
					<div class="col-sm-10">
					<input class="form-control" type="password" id="override_password_char_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_char_three">Characters: database port</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_port_char_three" value="3306" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_hostname_world_three">World: database hostname</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_hostname_world_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_username_world_three">World: database username</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_username_world_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_password_world_three">World: database password</label>
					<div class="col-sm-10">
					<input class="form-control" type="password" id="override_password_world_three" />
					</div>
					</div>
	
					<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="override_port_world_three">World: database port</label>
					<div class="col-sm-10">
					<input class="form-control" type="text" id="override_port_world_three" value="3306" />
					</div>
					</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="characters">Characters database</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="characters"/>
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="world">World database</label>
				<div class="col-sm-10">
				<input class="form-control" type="text" id="world" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="cap">Max allowed players online</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="cap" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="port">Realm port (cmangos: 8129, others: 8085)</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="port" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="emulator">Emulator</label>
				<div class="col-sm-10">
				<select class="form-control" id="emulator">
					{foreach from=$emulators key=emu_id item=emu_name}
						<option value="{$emu_id}">{$emu_name}</option>
					{/foreach}
				</select>
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_port">Console port (only required for emulators that use RA or SOAP; usually 3443 for RA and 7878 for SOAP)</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="console_port" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_username" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console username (only required for emulators that use remote console systems) (?)</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" id="console_username" />
				</div>
				</div>
	
				<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="console_password" data-toggle="tooltip" data-placement="bottom" title="For an ingame account with GM level high enough to connect to your<br />emulator console remotely (see your emulator's config files for more details)">Console password (only required for emulators that use remote console systems) (?)</label>
				<div class="col-sm-10">
					<input class="form-control" type="password" id="console_password" />
				</div>
				</div>
					<button class="btn btn-primary btn-sm" type="submit">Add realm</button>
			</form>
			
			</div>
			</div>
		</div>
        <div class="tab-pane" id="website">
           <form role="form" onSubmit="Settings.saveWebsiteSettings(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="title">Website title</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="title" placeholder="MyServer" value="{$config.title}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="server_name">Server name</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="server_name" placeholder="MyServer" value="{$config.server_name}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="realmlist">Realmlist</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="realmlist" placeholder="logon.myserver.com" value="{$config.realmlist}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="disabled_expansions">Max expansion</label>
			<div class="col-sm-10">
			<select class="form-control" id="disabled_expansions">
				<option value="cata" {if count($config.disabled_expansions) == 0}selected{/if}>Cataclysm</option>
				<option value="wotlk" {if count($config.disabled_expansions) == 1}selected{/if}>Wrath of the Lich King</option>
				<option value="tbc" {if count($config.disabled_expansions) == 2}selected{/if}>The Burning Crusade</option>
				<option value="none" {if count($config.disabled_expansions) == 3}selected{/if}>No expansion allowed</option>
			</select>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="keywords">Search engine: keywords (separated by comma)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="keywords" placeholder="world of warcraft,wow,private server,pvp" value="{$config.keywords}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="description">Search engine: description</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="description" placeholder="Best World of Warcraft private server in the entire world!" value="{$config.description}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="analytics"><a href="http://analytics.google.com" target="_blank">Google Analytics</a> website ID for advanced statistics (optional)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="analytics" placeholder="XX-YYYYYYYY-Z" value="{$config.analytics}"/>
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="cache">Cache on?</label>
			<div class="col-sm-10">
			<select class="form-control" name="cache" id="cache">
				<option value="true" {if $config.cache}selected{/if}>Yes</option>
				<option value="false" {if !$config.cache}selected{/if}>No</option>
			</select>
			</div>
			</div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="has_smtp">Enable password recovery (requires SMTP server)</label>
			<div class="col-sm-10">
			<select class="form-control" id="has_smtp">
				<option value="1" {if $config.has_smtp}selected{/if}>Yes</option>
				<option value="0" {if !$config.has_smtp}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-1">
			<label class="col-sm-2 col-form-label" for="vote_reminder">Enable vote reminder popup</label>
			<div class="col-sm-10">
			<select class="form-control" id="vote_reminder" onChange="Settings.toggleVoteReminder(this)">
				<option value="1" {if $config.vote_reminder}selected{/if}>Yes</option>
				<option value="0" {if !$config.vote_reminder}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="vote_reminder_settings" {if !$config.vote_reminder}style="display:none;"{/if}>
			<div class="form-group row mb-1">
			<label class="col-sm-2 col-form-label" for="vote_reminder_image">Vote reminder image URL</label>
			<div class="col-sm-10">
				<input class="form-control mb-1" type="text" id="vote_reminder_image" placeholder="http://mywebsite.com/images/banner.gif" value="{$config.vote_reminder_image}"/>
			</div>
			</div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="reminder_interval">Vote reminder interval (in hours)</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="reminder_interval" value="{$config.reminder_interval/60/24}" placeholder="12" />
			</div>
			</div>
			</div>
			
			<button class="btn btn-primary btn-sm" type="submit">Save settings</button>
		</form>
        </div>

        <div class="tab-pane" id="smtp">
		<form role="form" onSubmit="Settings.saveSmtpSettings(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="use_own_smtp_settings">Use own SMTP settings (enter them below)</label>
			<div class="col-sm-10">
			<select class="form-control" id="use_own_smtp_settings" onChange="Settings.toggleSMTPusage(this)">
				<option value="1" {if $config.use_own_smtp_settings}selected{/if}>Yes</option>
				<option value="0" {if !$config.use_own_smtp_settings}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div id="use_smtp" {if !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="smtp_protocol">Protocol</label>
			<div class="col-sm-10">
			<select class="form-control" id="smtp_protocol" onChange="Settings.toggleProtocol(this)">
				<option value="mail" {if $config.smtp_protocol == 'mail'}selected{/if}>Mail</option>
				<option value="sendmail" {if $config.smtp_protocol == 'sendmail'}selected{/if} disabled>SendMail (Linux only)</option>
				<option value="smtp" {if $config.smtp_protocol == 'smtp'}selected{/if}>SMTP</option>
			</select>
			</div>
            </div>
            </div>

			<div id="toggle_protocol" {if $config.smtp_protocol != 'smtp' || !$config.use_own_smtp_settings}style="display:none;"{/if}>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_sender">SMTP sender</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="smtp_sender" value="{$config.smtp_sender}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_host">SMTP hostname</label>
			<div class="col-sm-10">
			<input class="form-control" type="text" id="smtp_host" value="{$config.smtp_host}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_user">SMTP username</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="smtp_user" value="{$config.smtp_user}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_pass">SMTP password</label>
			<div class="col-sm-10">
			<input class="form-control" type="password" id="smtp_pass" value="{$config.smtp_pass}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="smtp_port">SMTP port</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="smtp_port" value="{$config.smtp_port}" />
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="smtp_crypto">SMTP crypto</label>
			<div class="col-sm-10">
			<select class="form-control" id="smtp_crypto">
				<option value="ssl" {if $config.smtp_crypto == 'ssl'}selected{/if}>SSL</option>
				<option value="tls" {if $config.smtp_crypto == 'tls'}selected{/if}>TLS</option>
			</select>
			</div>
            </div>
            </div>

			<button class="btn btn-primary btn-sm" type="submit">Save settings</button>
			<button class="btn btn-primary btn-sm" onclick="Settings.mailDebug(); return false">Mail debug</button>
		</form>
        </div>

        <div class="tab-pane" id="performance">
          <form role="form" onSubmit="Settings.savePerformanceSettings(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="disable_visitor_graph" data-toggle="tooltip" data-placement="bottom" title="If you have many visitors, the admin panel will become very slow because of the statistics graph - disabling it will help a lot">Disable dashboard visitor graph <a>(?)</a></label>
			<div class="col-sm-10">
			<select class="form-control" name="disable_visitor_graph" id="disable_visitor_graph">
				<option value="1" {if $config.disable_visitor_graph}selected{/if}>Yes</option>
				<option value="0" {if !$config.disable_visitor_graph}selected{/if}>No</option>
			</select>
			</div>
			</div>
			<button class="btn btn-primary btn-sm" type="submit">Save settings</button>
		</form>
        </div>

		<div class="tab-pane" id="social_media">
          <form role="form" onSubmit="Settings.saveSocialMedia(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="fb_link">Facebook</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="fb_link" value="{$config.facebook}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="twitter_link">Twitter</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="twitter_link" value="{$config.twitter}" />
			</div>
            </div>

			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="yt_link">Youtube</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="yt_link" value="{$config.youtube}" />
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="discord_link">Discord</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="discord_link" value="{$config.discord}" />
			</div>
            </div>

			<button class="btn btn-primary btn-sm" type="submit">Save social links</button>
		</form>
        </div>

		<div class="tab-pane" id="cdn">
          <form role="form" onSubmit="Settings.saveCDN(); return false">
			<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="cdn_value">CDN</label>
			<div class="col-sm-10">
			<select class="form-control" id="cdn_value">
				<option value="true" {if $config.cdn_value == '1'}selected{/if}>Yes</option>
				<option value="false" {if $config.cdn_value == '0'}selected{/if}>No</option>
			</select>
			</div>
            </div>

			<div class="form-group row mb-3">
			<label class="col-sm-2 col-form-label" for="cdn_link">CDN URL</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" id="cdn_link" value="{$config.cdn_link}" />
			</div>
            </div>

			<button class="btn btn-primary btn-sm" type="submit">Save CDN</button>
		</form>
		<div class="alert alert-dark mt-3" role="alert">
			Do you like the CDN system and want to continue using it? We would appreciate your help!<br>
			With a small <a href="https://github.com/FusionGen/FusionGEN/blob/main/.github/FUNDING.yml">donation</a> of only $5 you help to keep the CDN system alive
		</div>
        </div>
    </div>
</div>
</div>
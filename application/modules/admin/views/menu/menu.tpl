<script type="text/javascript">
	var customPages = JSON.parse('{json_encode($pages)}');
</script>

<section class="box big" id="main_link">
	<h2>
		Menu links (<div style="display:inline;" id="link_count">{if !$links}0{else}{count($links)}{/if}</div>)
	</h2>

	{if hasPermission("addMenuLinks")}
	<span>
		<a class="nice_button" href="javascript:void(0)" onClick="Menu.add()">Create link</a>
	</span>
	{/if}

	<ul id="link_list">
		{if $links}
		{foreach from=$links item=link}
			<li>
				<table width="100%">
					<tr>
						<td width="10%">
							{if hasPermission("editMenuLinks")}
							<a href="javascript:void(0)" onClick="Menu.move('up', {$link.id}, this)" data-tip="Move up"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_up.png" /></a>
							<a href="javascript:void(0)" onClick="Menu.move('down', {$link.id}, this)" data-tip="Move down"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_down.png" /></a>
							{/if}
						</td>
						<td width="30%"><span style="font-size:10px;padding:0px;display:inline;">{$link.side}&nbsp;&nbsp;</span> <b>{langColumn($link.name)}</b></td>
						<td width="50%"><a href="{$link.link}" target="_blank">{$link.link_short}</a></td>
						<td style="text-align:right;">
							{if hasPermission("editMenuLinks")}
							<a href="{$url}admin/menu/edit/{$link.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>
							{/if}
							&nbsp;
							{if hasPermission("deleteMenuLinks")}
							<a href="javascript:void(0)" onClick="Menu.remove({$link.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
							{/if}
						</td>
					</tr>
				</table>
			</li>
		{/foreach}
		{/if}
	</ul>
</section>

<section class="box big" id="add_link" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Menu.add()" data-tip="Return to menu links">Menu links</a> &rarr; New link</h2>

	<form onSubmit="Menu.create(this); return false" id="submit_form">
		<label for="name">Title</label>
		<input type="text" name="name" id="name" placeholder="My link" />

		<label for="type" data-tip="External links must begin with http://">URL (or <a href="javascript:void(0)" onClick="Menu.selectCustom()">select from custom pages</a>) <a>(?)</a></label>
		<input type="text" name="link" id="link" placeholder="http://"/>

		<label for="side">Menu location</label>
		<select name="side" id="side">
				<option value="top">Top</option>
				<option value="side">Side</option>
		</select>

		<label for="visibility">Visibility mode</label>
		<select name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
			<option value="everyone" selected>Visible to everyone</option>
			<option value="group">Controlled per group</option>
		</select>

		<div id="groups" style="display:none;">
			Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the link
		</div>

<label for="direct_link" data-tip="If you want to link to a non-FusionCMS page on the same domain, you must select 'Yes' otherwise FusionCMS will try to load it 'inside' the theme.">Internal direct link <a>(?)</a></label>
		<select name="direct_link" id="direct_link">
				<option value="0">No</option>
				<option value="1">Yes</option>
		</select>
	
		<input type="submit" value="Submit link" />
	</form>
</section>

<script>
	require([Config.URL + "application/themes/admin/js/mli.js"], function()
	{
		new MultiLanguageInput($("#name"));
	});
</script>
{TinyMCE()}
<section class="box big" id="pages">
	<h2>
		Pages (<div style="display:inline;" id="page_count">{if !$pages}0{else}{count($pages)}{/if}</div>)
	</h2>

	{if hasPermission("canAdd")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Pages.show()">Create page</a>
		</span>
	{/if}

	<ul id="pages_list">
		{if $pages}
		{foreach from=$pages item=page}
			<li>
				<table width="100%">
					<tr>
						<td width="25%"><a href="{$url}page/{$page.identifier}/" target="_blank">/page/{$page.identifier}/</a></td>
						<td width="60%"><b>{$page.name}</b></td>
						<td style="text-align:right;">
							{if hasPermission("canEdit")}
							<a href="{$url}page/admin/edit/{$page.id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
							{/if}

							{if hasPermission("canRemove")}
								<a href="javascript:void(0)" onClick="Pages.remove({$page.id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
							{/if}
						</td>
					</tr>
				</table>
			</li>
		{/foreach}
		{/if}
	</ul>
</section>

<div id="add_pages" style="display:none;">
	<section class="box big">
		<h2><a href='javascript:void(0)' onClick="Pages.show()" data-tip="Return to pages">Pages</a> &rarr; New page</h2>

		<form onSubmit="Pages.send(); return false">
			<label for="headline">Headline</label>
			<input type="text" id="headline" />
			
			<label for="identifier">Unique link identifier (as in mywebsite.com/page/<b>mypage</b>)</label>
			<input type="text" id="identifier" placeholder="mypage" />

			<label for="visibility">Visibility mode</label>
			<select name="visibility" id="visibility" onChange="if(this.value == 'group'){ $('#groups').fadeIn(300); } else { $('#groups').fadeOut(300); }">
				<option value="everyone" selected>Visible to everyone</option>
				<option value="group">Controlled per group</option>
			</select>

			<div id="groups" style="display:none;">
				Please manage the group visibility via <a href="{$url}admin/aclmanager/groups">the group manager</a> once you have created the page
			</div>

			<label for="pages_content">
				Content
			</label>
		</form>
			<div style="padding:10px;">
				<textarea name="pages_content" class="tinymce" id="pages_content" cols="30" rows="10"></textarea>
			</div>
		<form onSubmit="Pages.send(); return false">
			<input type="submit" value="Submit page" />
		</form>
	</section>
</div>

<script>
	require([Config.URL + "application/themes/admin/js/mli.js"], function()
	{
		new MultiLanguageInput($("#headline"));
	});
</script>
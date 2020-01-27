<section class="box big" id="main_changelog">
	<h2>
		Changes (<div style="display:inline;" id="changelog_count">{if !$changes}0{else}{count($changes)}{/if}</div>)
	</h2>
	
	{if hasPermission("canAddCategory")}
		<span>
			<a class="nice_button" href="javascript:void(0)" onClick="Changelog.add()">Create category</a>
		</span>
	{/if}

	{if $categories}
	{foreach from=$categories item=category}
		<ul id="changelog_list">
			<li id="headline_{$category.id}">
				<table width="100%">
					<tr>
						{if hasPermission("canAddChange")}
							<td width="5%"><a href="javascript:void(0)" onClick="Changelog.addChange({$category.id})" data-tip="Add change"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_plus.png" /></a></td>
						{/if}
						<td><b>{$category.typeName}</b></td>
						
						<td style="text-align:right;" width="10%">
							
							{if hasPermission("canEditCategory")}
								<a href="javascript:void(0)" onClick="Changelog.renameCategory({$category.id}, this)" data-tip="Rename category"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
							{/if}
							
							{if hasPermission("canRemoveCategory")}
								<a href="javascript:void(0)" onClick="Changelog.removeCategory({$category.id}, this)" data-tip="Delete category and all its entries"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
							{/if}
						</td>
					</tr>
				</table>
			</li>
			{foreach from=$changes item=change}
				{if $category.id == $change.type}
					<li>
						<table width="100%">
							<tr>
								<td width="40%">{$change.changelog}</td>
								<td width="20%">{$change.author}</td>
								<td width="20%">{date('Y/m/d', $change.time)}</td>
								
								<td style="text-align:right;" width="10%">
									{if hasPermission("canEditChange")}
										<a href="{$url}changelog/admin/edit/{$change.change_id}" data-tip="Edit"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_edit.png" /></a>&nbsp;
									{/if}

									{if hasPermission("canRemoveChange")}
										<a href="javascript:void(0)" onClick="Changelog.remove({$change.change_id}, this)" data-tip="Delete"><img src="{$url}application/themes/admin/images/icons/black16x16/ic_minus.png" /></a>
									{/if}
								</td>
							</tr>
						</table>
					</li>
				{/if}
			{/foreach}
		</ul>
	{/foreach}
	{/if}
</section>

<section class="box big" id="add_changelog" style="display:none;">
	<h2><a href='javascript:void(0)' onClick="Changelog.add()" data-tip="Return to changelog">Changelog</a> &rarr; New category</h2>

	<form onSubmit="Changelog.create(this); return false" id="submit_form">
		<label for="name">Category name</label>
		<input type="text" name="typeName" id="typeName" />
	
		<input type="submit" value="Submit category" />
	</form>
</section>
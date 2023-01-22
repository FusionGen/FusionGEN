<div class="row">
<div class="tabs">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#items" data-bs-target="#items" data-bs-toggle="tab">Items</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#groups" data-bs-target="#groups" data-bs-toggle="tab">Groups</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="items">
			<div class="btn-toolbar justify-content-between">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search Here" id="ItemSeachInput">
				</div>
				{if hasPermission("canAddItems")}
					<span class="pull-right">
						<a class="btn btn-primary btn-sm" href="{$url}store/admin_items/add_item">Create item</a>
					</span>
				{/if}
			</div>

			{if $items}
			<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>Icon</th>
					<th>Name</th>
					<th>Description</th>
					<th>Group</th>
					<th>Price</th>
					<th style="text-align:center;">Actions</th>
				</tr>
			</thead>
			<tbody id="ItemTableResult">
			{foreach from=$items item=item}
				<tr>
					<td><img style="opacity:1;" src="https://icons.wowdb.com/retail/small/{$item.icon}.jpg" /></td>
					<td data-bs-toggle="tooltip" data-placement="top" data-html="true" title="{$item.name}"><b class="q{$item.quality}">{character_limiter($item.name, 30)}</b></td>
					<td data-bs-toggle="tooltip" data-placement="top" data-html="true" title="{$item.description}">{character_limiter($item.description, 20)}</td>
					<td>{if array_key_exists("title", $item) && $item.title}{$item.title}{/if}</td>
					<td>
						{if $item.vp_price}
							<img src="{$url}application/images/icons/lightning.png" style="opacity:1;margin-top:3px;position:absolute;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$item.vp_price} VP
						{/if}
						{if $item.dp_price}
							<img src="{$url}application/images/icons/coins.png" style="opacity:1;margin-top:3px;position:absolute;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							{$item.dp_price} DP
						{/if}
					</td>
					<td style="text-align:center;">
						{if hasPermission("canEditItems")}
							<a class="btn btn-primary btn-sm" href="{$url}store/admin_items/edit/{$item.id}">Edit</a>
						{/if}
			
						{if hasPermission("canRemoveItems")}
							<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Items.remove({$item.id}, this)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
			</tbody>
			</table>
			{/if}
      	</div>
      	<div class="tab-pane" id="groups">
			{if hasPermission("canAddGroups")}
			<span class="pull-right">
				<a class="btn btn-primary btn-sm" href="{$url}store/admin_items/add_group">Create group</a>&nbsp;
			</span>
			{/if}
			<td>{if $groups}
			<table class="table table-responsive-md table-hover">
			<thead>
				<tr>
					<th>Order #</th>
					<th>Name</th>
					<th style="text-align:center;">Actions</th>
				</tr>
			</thead>
			{foreach from=$groups item=group}
				<tr>
					<td>{$group.orderNumber}</td>
					<td>{$group.title}</td>
					<td style="text-align:center;">
						{if hasPermission("canEditGroups")}
							<a class="btn btn-primary btn-sm" href="{$url}store/admin_items/edit_group/{$group.id}">Edit</a>
						{/if}
			
						{if hasPermission("canRemoveGroups")}
							<a class="btn btn-primary btn-sm" href="javascript:void(0)" onClick="Items.removeGroup({$group.id}, this, true)">Delete</a>
						{/if}
					</td>
				</tr>
			{/foreach}
			</table>
			{/if}
      	</div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
   
        $("#ItemSeachInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();     
            $("#ItemTableResult tr").filter(function () {
                $(this).toggle($(this).text()
                  .toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
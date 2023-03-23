{if !$found}
<section class="card">
	<header class="card-header">
		<div class="card-actions">
			<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
			<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
		</div>

		<h2 class="card-title">Accounts</h2>
	</header>
	<div class="card-body">
		<table class="table table-bordered table-striped" id="acclist">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>EMail</th>
					<th>Joindate</th>
					<th>Expansion</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</section>
{/if}

<div id="form_accounts_search" class="mb-3">
	{if $found}
		<script type="text/javascript">
			$(document).ready(function()
			{
				function checkIfLoaded()
				{
					if(typeof Accounts != "undefined")
					{
						Accounts.getAccount({$data.id});
					}
					else
					{
						setTimeout(checkIfLoaded, 50);
					}
				}

				checkIfLoaded();
			});
		</script>
	{else}
		<!-- results -->
	{/if}
</div>

<script>
$(document).ready(function() {
    var table = $('#acclist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{$url}admin/accounts/get_accs_ajax",
            "type": "POST",
            "data": function(d) {
                d.csrf_token_name = Config.CSRF,
                d.search = $('input[type="search"]').val();
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "email" },
            { "data": "joindate" },
            { "data": "expansion" },
            { "data": null, "render": function(data, type, row, meta) {
                return '<a href="{$url}admin/accounts/get/'+row.id+'">View</a>';
            }}
        ]
    });

    // Suche durchführen, wenn Suchbegriff geändert wird
    $('input[type="search"]').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>

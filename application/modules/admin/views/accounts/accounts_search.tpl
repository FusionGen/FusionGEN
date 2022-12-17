{if !$found}
<div class="card">
	<header class="card-header">
		<div class="card-actions">
			<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
			<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
		</div>

		<h2 class="card-title">Search</h2>
	</header>
	<div class="card-body">
		<select class="form-control" name="search_accounts" id="search_accounts"></select>
	</div>
</div>

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
				</tr>
			</thead>
			<tbody>
			{if $accounts}
				{foreach from=$accounts item=accs}
					<tr>
						<td>{$accs.id}</td>
						<td>{$accs.username}</td>
						<td>{$accs.email}</td>
						<td>{$accs.joindate}</td>
						<td>{$accs.expansion}</td>
					</tr>
				{/foreach}
			{/if}
			</tbody>
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
    $('#acclist').DataTable();
} );
</script>

<script>
$(document).ready(function(){
    $("#search_accounts").select2({
		theme: "classic",
		placeholder: 'Search for accountname or email',
		minimumInputLength: 1,
        ajax: { 
            url: "{$url}admin/accounts/select2",
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.username + ' - ' + obj.email
                            };
                        })
                    };
                }
        }
    });
});
</script>

<script type="text/javascript">
	$(document).on('select2:open', () => {
		document.querySelector('.select2-search__field').focus();
	});

    $(document).ready(function() {
    $("#search_accounts-single").select2();

    $("#search_accounts").on("select2:select", function (e) {
	window.open('{$url}admin/accounts/get/' + e.params.data.id, '_self');
	});

    });
</script>
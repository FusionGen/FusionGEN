<section class="box big" id="account_articles">
	<h2>
		Search
	</h2>

	<form style="margin-top:0px;" onSubmit="Accounts.searchAccount(); return false;">
		<input type="text" name="search_accounts" {if $auto}value="{$data.username}" {/if}id="search_accounts" placeholder="Search by username or email" style="width:90%;margin-right:5px;"/>
		<input type="submit" value="Search" style="display:inline;padding:8px;" />
	</form>

	<div id="form_accounts_search">
		{if $auto}
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
</section>
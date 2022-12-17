<script type="text/javascript">
	if(typeof Search != "undefined")
	{
		Search.current = null;
	}
</script>

<form onSubmit="Search.submit();return false;">
	<div class="row py-3 justify-content-lg-end">
		<div class="col-10 col-lg-11">
			<input class="form-control" type="text" id="search_field" name="search_field" placeholder="{lang('search_placeholder', 'armory')}">
		</div>
		<div class="col-1 text-center">
			<input type="submit" class="nice_button" value="{lang('search_button', 'armory')}">
		</div>
	</div>
</form>

<div id="amory_result"></div>

<hr class="my-5" />

<div id="search_box">
	<div id="search_results"></div>
</div>
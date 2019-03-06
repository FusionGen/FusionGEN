<script type="text/javascript">
	{literal}
	var TopPvP = {

		current: 0,

		show: function(id)
		{	
			$("#toppvp_realm_" + this.current).fadeOut(150, function()
			{
				TopPvP.current = id;
				$("#toppvp_realm_" + id).fadeIn(150);
			});
		}
	};
	{/literal}

	$(document).ready(function()
	{
		TopPvP.current = {$min_realm-1};
		$("#toppvp_realm_{$min_realm-1}").fadeIn(150);
	});
</script>
<div id="toppvp">
	{foreach from=$realms key=key item=realm}
		<div class="toppvp_realm" id="toppvp_realm_{$key - 1}" style="display:none;">
			<div class="toppvp_select">
				{if $key != $max_realm}<a href="javascript:void(0)" onClick="TopPvP.show(TopPvP.current + 1)" class="toppvp_next" data-tip="{lang("next", "sidebox_toppvp")}">&rarr;</a>{/if}
				{if $key != $min_realm && $max_realm != 1}<a href="javascript:void(0)" onClick="TopPvP.show(TopPvP.current - 1)" class="toppvp_previous"  data-tip="{lang("previous", "sidebox_toppvp")}">&larr;</a>{/if}
				{$realm->getName()}
			</div>
			<div class="toppvp_data">
				{$realm_html.$key}
			</div>
		</div>
	{/foreach}
	<div style="clear:both;"></div>
</div>
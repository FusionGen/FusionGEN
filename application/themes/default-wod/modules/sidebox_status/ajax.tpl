<div id="update_status">
	<div style="text-align:center;margin-top:10px;margin-bottom:10px;">
		<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
	</div>
</div>

<!-- div class="realmlist-info box">
	<div class="body">set realmlist {$CI->config->item('realmlist')}</div>
</div -->

<script type="text/javascript">
	// The cleanest way, but hacky :/
	/* $('.realmlist-info.box').insertAfter($('.realmlist-info.box').parents('.box').addClass('type-status')); */
	
	var Status = {
		statusField: $("#update_status"),
		
		/**
		 * Refresh the realm status
		 */
		update: function()
		{
			$.get(Config.URL + "sidebox_status/status_refresh", function(data)
			{
				Status.statusField.fadeOut(300, function()
				{
					Status.statusField.html(data);
					Status.statusField.fadeIn(300);
				})
			});
		}
	}

	Status.update();
</script>
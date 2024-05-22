<section id="update_online_module">
	<div class="text-center my-4">
		<i class="fas fa-spinner fa-pulse fa-xl"></i>
	</div>
</section>

<script>
	var OnlineModule = {
		field: $("#update_online_module"),

		/**
		 * Refresh the realm status
		 */
		update: function()
		{
			$.get(Config.URL + "online/online_refresh", function(data)
			{
				OnlineModule.field.fadeOut(300, function()
				{
					OnlineModule.field.html(data);
					OnlineModule.field.fadeIn(300, function()
					{
						Tooltip.refresh();
					});
				})
			});
		}
	}

	OnlineModule.update();
</script>

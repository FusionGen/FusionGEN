<section id="update_status">
	<div class="text-center my-4">
		<i class="fas fa-spinner fa-pulse fa-xl"></i>
	</div>
</section>

<script>
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

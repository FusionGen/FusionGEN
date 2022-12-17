var Logging = {
	offset: 0,
	loadMoreCount: 10,
    logCount: 0,
    id: 0,

	search: function()
	{
		var module = $('#module').val();
		var search = $('#search').val();

		$("#log_list").html('<center><img src="' + Config.URL + 'application/themes/admin/images/ajax.gif" /><br /><br /></center>');

		$.post(Config.URL + "admin/logging/search", {search: search, module: module, csrf_token_name: Config.CSRF}, function(data)
		{
			$("#log_list").fadeOut(150, function()
			{
				$(this).html(data).fadeIn(500, function()
				{
					Tooltip.refresh();
				});
			});
		});
	},

	loadMore: function()
	{
		this.id++;

		this.offset += this.loadMoreCount;
        this.logCount = $('#js_load_more').val();

        // Hide the load more
        $("#show_more_count").remove();

        // Show ajax loading here

        // Do the post request.
		$.post(Config.URL + "admin/logging/loadMoreLogs", {offset: this.offset, count: this.loadMoreCount, show_more: this.logCount, csrf_token_name: Config.CSRF}, function(data)
		{
			data = "<div id='new_logs_" + Logging.id + "'>" + data + "</div>";

			$("#log_list").append(data);

			$("#new_logs_" + Logging.id).fadeIn(300, function()
			{
				Tooltip.refresh();
			});
		});
	}
}
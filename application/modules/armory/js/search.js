var Search = {
	/**
	 * Get search results
	 */
	submit: function() {
		var results = $("#amory_result");
		var value = $("#search_field").val();

		if(value.length > 0) {
			
			$.post(Config.URL + "armory/search", {search: value, csrf_token_name: Config.CSRF}, function(data) {
				results.html(data);
				results.show();
				Tooltip.refresh();
			});
		} else {
			Swal.fire({
				title: 'Oops...',
				text: lang("cant_be_empty", "armory"),
				icon: 'error',
				target: 'body',
				toast: true,
				position: 'bottom-right',
				timer: 10000,
				timerProgressBar: true,
				showConfirmButton: false,
			});
		}
	},

	/**
	 * Change to a tab
	 * @param Int tab
	 */
	showTab: function(tab, element)
	{
		//Remove and add active to list item
		$(".list-cat a").removeClass("active");
		$(element).addClass("active");
		
		//Hide and open tab
		$('.search-tab').removeClass("d-block");
		$('.search-tab').addClass("d-none");
		
		$('.search-tab[data-tab-id="'+ tab +'"]').removeClass("d-none");
		$('.search-tab[data-tab-id="'+ tab +'"]').addClass("d-block");
	},

	/**
	 * Toggle the visiblity of content of a realm
	 * @param Int realm
	 * @param Element field
	 */
	 toggleRealm: function(realm, field)
	 {
	 	var obj = $(field);
	 	
	 	if(obj.hasClass("active"))
	 	{
	 		obj.removeClass("active");
			$('tr[data-realm-id="'+ realm +'"]').hide();
	 	}
	 	else
	 	{
	 		obj.addClass("active");
			$('tr[data-realm-id="'+ realm +'"]').show();
	 	}
	 }
}
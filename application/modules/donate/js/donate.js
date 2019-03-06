var Donate = {
	
	/**
	 * Show the PayPal donation area
	 * @param Object button
	 */
	showPayPal: function(button)
	{
		$(".nice_active").removeClass("nice_active");
		$(button).addClass("nice_active");

		$("#paygol_area").hide();
		$("#paypal_area").show();
	},

	/**
	 * Show the PayGol donation area
	 * @param Object button
	 */
	showPayGol: function(button)
	{
		$(".nice_active").removeClass("nice_active");
		$(button).addClass("nice_active");

		$("#paypal_area").hide();
		$("#paygol_area").show();
	}
}
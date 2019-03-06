<?php

/*
|--------------------------------------------------------------------------
| General settings
|--------------------------------------------------------------------------
*/

$config['donation_currency'] = "USD"; // Remember to change the currency ON PayGol as well!
$config['donation_currency_sign'] = "$";

/*
|--------------------------------------------------------------------------
| PayPal Donation (www.paypal.com)
|--------------------------------------------------------------------------
*/

$config['donate_paypal'] = array(
	'use' => true, // true: enable | false: disable
	'postback_url' => "http://YOURSERVER.COM/donate/postback_paypal",
	'return_url' => "http://YOURSERVER.COM/donate/success",
	'email' => "CHANGEME@example.com",
	'sandbox' => false, // false: live servers | true: testing/dev servers
	
	'values' => array(

		// Format: PRICE => DP
		// Example: 5 => 15 which would cause 5 USD
		// (or your specified currency) to give 15 DP

		5 => 15,
		10 => 20,
		20 => 50,
		40 => 100,
		60 => 150,
		80 => 200,
		100 => 300
	),

);

/*
|--------------------------------------------------------------------------
| PayGol Donation (www.paygol.com)
|--------------------------------------------------------------------------
*/

$config['donate_paygol'] = array(
	'use' => true, // true: enable | false: disable
	'service_id' => 123456, // Your PayGol service ID
	'cancel_url' => "http://YOURSERVER.COM/donate",
	'return_url' => "http://YOURSERVER.COM/donate/success",
	
	'values' => array(

		// Format: PRICE => DP
		// Example: 5 => 15 which would cause 5 USD
		// (or your specified currency) to give 15 DP

		20 => 30,
		30 => 40,
		40 => 60,
		60 => 90,
	),

);





/*******************************************************************/
/******************* Only Jesper allowed ***************************/
/*******************************************************************/

// Touch it and I'll kill you! >:(
$config['force_code_editor'] = true;
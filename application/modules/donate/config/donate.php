<?php

/*
|--------------------------------------------------------------------------
| General settings
|--------------------------------------------------------------------------
*/

$config['donation_currency'] = "EUR"; // Remember to change the currency ON PayGol as well!
$config['donation_currency_sign'] = "€";

/*
|--------------------------------------------------------------------------
| PayPal Donation (www.paypal.com)
|--------------------------------------------------------------------------
*/

$config["use_paypal"] = true;
$config["donate_paypal"] = array(
    "use" => true
);

/**
 * PayPal Mode
 *
 * Options Available:
 *
 * sandbox = Testing the code end-to-end
 * live    = Ready for production
*/
$config["paypal_mode"] = "sandbox";

/**
 * PayPal Client ID
 *
 * Check your client id in:
 * https://developer.paypal.com/developer/applications
*/
$config["paypal_userid"] = "";

/**
 * PayPal Secret Password
 *
 * Check your secret password in:
 * https://developer.paypal.com/developer/applications
*/
$config["paypal_secretpass"] = "";


/*******************************************************************/
/*******************
 * Only Err0r allowed 
********************/
/*******************************************************************/

// Touch it and I'll kill you! >:(
$config['force_code_editor'] = true;

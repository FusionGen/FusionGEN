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
$config["paypal_userid"] = "AYca6WjE5OL4G1570-DDoiL3ubAIlfkt3XaBxXMC2Q0NJyFHd84Nx-20JwN7GPPbsL4JU0yMYw0aa2C3";

/**
 * PayPal Secret Password
 *
 * Check your secret password in:
 * https://developer.paypal.com/developer/applications
*/
$config["paypal_secretpass"] = "EOvtTOG5PE8jLTRvZ1dgjX3yHobj3KxX_VfD8OLeLYNdt4pFlkOhZct_hSDAp9I36A6dahCbQ5fSGjZi";


/*******************************************************************/
/*******************
 * Only Err0r allowed 
********************/
/*******************************************************************/

// Touch it and I'll kill you! >:(
$config['force_code_editor'] = true;

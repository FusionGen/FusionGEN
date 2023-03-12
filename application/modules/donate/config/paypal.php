<?php

/*
|--------------------------------------------------------------------------
| General settings
|--------------------------------------------------------------------------
*/

$config['donation_currency'] = "USD";
$config['donation_currency_sign'] = "$";

/*
|--------------------------------------------------------------------------
| PayPal Donation (www.paypal.com)
|--------------------------------------------------------------------------
*/

$config['use_paypal'] = true;

/**
 * PayPal Mode
 *
 * Options Available:
 *
 * sandbox = Testing the code end-to-end
 * live    = Ready for production
*/
$config['paypal_mode'] = "sandbox";

/**
 * PayPal Client ID
 *
 * Check your client id in:
 * https://developer.paypal.com/developer/applications
*/
$config['paypal_userid'] = "AS6enu-55A8Q4lCmUbl_3LD5rwfdFaMqCvtGk0YgAw-1SWAwqLkSQvAD9qQHLYc4boz8Qf8r7xvmx63y";

/**
 * PayPal Secret Password
 *
 * Check your secret password in:
 * https://developer.paypal.com/developer/applications
*/
$config['paypal_secretpass'] = "EGHXycrMMKloP98u3bCLwyZGzHWbZATYSU3tyeEroDvpenyOzwQEnECagdZdlQpKI8LMvL9Z-Jc3M-f1";

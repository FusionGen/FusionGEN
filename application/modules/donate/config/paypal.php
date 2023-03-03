<?php

/*
|--------------------------------------------------------------------------
| General settings
|--------------------------------------------------------------------------
*/

$config['donation_currency'] = "EUR";
$config['donation_currency_sign'] = "€";

/*
|--------------------------------------------------------------------------
| PayPal Donation (www.paypal.com)
|--------------------------------------------------------------------------
*/

$config["use_paypal"] = true;

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
$config["paypal_userid"] = "AUzIfDDtTcDkirP_5PyJ3bPWPEHpd1mGUFVZ2TnYLOc_pkblCw9Z7bL8_rhzKw3vwPwnuUlJETNS8znU";

/**
 * PayPal Secret Password
 *
 * Check your secret password in:
 * https://developer.paypal.com/developer/applications
*/
$config["paypal_secretpass"] = "EOBBUs_Enf-tJR3PgOJsyNnUPsQ3VDAj8ZaODYntRlXh9p1yvhmpBfVbLP22TP4z9xI_AsbS9geDRMhx";

<?php
// For example scripts and PHPUnit testing.
// Populate your keys below and then rename this file to "keys.php"
// Generate and edit your key permissions here: https://www.coinpayments.net/acct-api-keys
$private_key = '';
$public_key = '';

// The following variables are only needed for running tests of the PHPUnit CoinpaymentsAPITest class or if you wish to use the constants defined at the bottom of this file for your own testing.
// A LTCT address to send from
$ltct_address_from = '';

// A LTCT address to send to
$ltct_address_to = '';

// An alternate merchant ID of a second development account to send LTCT to from your main account
$alternate_merchant_id = '';

// A valid ID for a past withdrawal from your CoinPayments.net account to another address
$withdrawal_id = '';

// Two valid IDs for past transactions from your CoinPayments.net account where you are the seller.
$txid_one = '';
$txid_two = '';

// A buyer email for testing the creation of transactions
$buyer_email = '';

// A $PayByName tag to test sending transfer to
$pbn_tag = '';

// The tagid for a $PayByName tag to test updating a tag profile
$pbn_update_id = '';

// Location of an image to test the $PayByName profile update
// Must be smaller than 250kb
// Should include full path to image on local filesystem
$pbn_update_img = '';

// Currency tickers and an amount to test converting coins from and to
$convert_from = '';
$convert_to = '';
$convert_amount = '';

// A previous conversion ID to lookup information on
$conversion_id = '';

// The tag ID of an unused $PayByName used to claim a name.
$empty_pbn_tag_id = '';

// The name of the $PayByName tag that will be claimed when running the test for the 'claim_pbn_tag' API command.
$new_pbn_tag_name = '';

// No need to edit the lines below
$txid_multi = $txid_one . '|' . $txid_two;
define('API_PRIVATE_KEY', $private_key);
define('API_PUBLIC_KEY', $public_key);
define('API_TESTS_LTCT_FROM', $ltct_address_from);
define('API_TESTS_LTCT_TO', $ltct_address_to);
define('API_TESTS_ALT_MID', $alternate_merchant_id);
define('API_TESTS_WID', $withdrawal_id);
define('API_TESTS_TXID_SINGLE', $txid_one);
define('API_TESTS_TXID_MULTI', $txid_multi);
define('API_TESTS_BUYER_EMAIL', $buyer_email);
define('API_TESTS_PBN', $pbn_tag);
define('API_TESTS_PBN_UPDATE_ID', $pbn_update_id);
define('API_TESTS_PBN_UPDATE_IMG', $pbn_update_img);
define('API_TESTS_PBN_EMPTY_ID', $empty_pbn_tag_id);
define('API_TESTS_NEW_PBN_NAME', $new_pbn_tag_name);
define('API_TESTS_CONVERT_FROM', $convert_from);
define('API_TESTS_CONVERT_TO', $convert_to);
define('API_TESTS_CONVERT_AMOUNT', $convert_amount);
define('API_TESTS_CONVERSION_ID', $conversion_id);

<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Create a transfer to a merchant identified by their merchant ID. **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Enter amount for the transaction
$amount = 0.005;

// Litecoin Testnet is a no value currency for testing
$currency = 'LTCT';

// Enter the merchant ID to send funds to
$merchant = '';

// If you want to skip email confirmation, include the following variable as the fourth parameter in the API call below.
// $auto_confirm = 1;

// Make call to API to create the transaction
try {
    $transfer = $cps_api->CreateMerchantTransfer($amount, $currency, $merchant);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

if ($transfer['error'] == 'ok') {
    // Success!
    $output = 'Transfer created with ID: ' . $transfer['result']['id'] . '<br>';
    $output .= 'Status of transfer is: ' . $transfer['result']['status'];

} else {
    // Something went wrong!
    $output = 'Error: ' . $transfer['error'];
}

// Output the response of the API call
echo $output;

<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Create a simple transaction. **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Enter amount for the transaction
$amount = 0.005;

// Litecoin Testnet is a no value currency for testing
$currency = 'LTCT';

// Enter buyer email below
$buyer_email = '';

// Make call to API to create the transaction
try {
    $transaction_response = $cps_api->CreateSimpleTransaction($amount, $currency, $buyer_email);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

if ($transaction_response['error'] == 'ok') {
    // Success!
    $output = 'Transaction created with ID: ' . $transaction_response['result']['txn_id'] . '<br>';
    $output .= 'Amount for buyer to send: ' . $transaction_response['result']['amount'] . '<br>';
    $output .= 'Address for buyer to send to: ' . $transaction_response['result']['address'] . '<br>';
    $output .= 'Seller can view status here: ' . $transaction_response['result']['status_url'];

} else {
    // Something went wrong!
    $output = 'Error: ' . $transaction_response['error'];
}

// Output the response of the API call
echo $output;

<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Create a complex transaction that uses all available fields. **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Enter amount for the transaction
// This would be the price for the product or service that you're selling
$amount = 50.00;

// The currency for the amount above (original price)
$currency1 = 'USD';

// Litecoin Testnet is a no value currency for testing
// The currency the buyer will be sending equal to amount of $currency1
$currency2 = 'LTCT';

// Enter buyer email below
$buyer_email = '';

// Set a custom address to send the funds to.
// Will override the settings on the Coin Acceptance Settings page
$address = '';

// Enter a buyer name for later reference
$buyer_name = 'John Blockchain';

// Enter additional transaction details
$item_name = 'Fancy Dongle';
$item_number = '2018';
$custom = 'Express order';
$invoice = 'JB-2018-1';
$ipn_url = 'https://not-a-real-website.com/your_ipn_handler_script.php';

// Make call to API to create the transaction
try {
    $transaction_response = $cps_api->CreateComplexTransaction($amount, $currency1, $currency2, $buyer_email, $address, $buyer_name, $item_name, $item_number, $invoice, $custom, $ipn_url);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Output the response of the API call
if ($transaction_response["error"] == "ok") {
    var_dump($transaction_response);
} else {
    echo $transaction_response["error"];
}

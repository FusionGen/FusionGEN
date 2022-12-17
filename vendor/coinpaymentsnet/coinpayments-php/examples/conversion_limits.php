<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Show conversion limits between multiple currency pairings.**/

// Setup pairings in the format "from|to" using currency tickers
$pairings = [
    'BTC|LTC',
    'BCH|ETH',
    'XRP|XMR', // This pairing does not support conversions and should throw an error.
    'XEM|ZEC'  // This pairing does not support conversions and should throw an error.
];

// Prepare output and empty array for storing errors
$output = '<table><tbody><tr><td>From</td><td>To</td><td>Minimum</td><td>Maximum</td></tr>';
$errors = [];

// Loop through pairings, making API calls for each
foreach ($pairings as $pairing) {

    // Split the pairing into a from and to value
    $pairing_split = explode('|', $pairing);
    $from = $pairing_split[0];
    $to = $pairing_split[1];

    // Attempt the API call
    try {
        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
        $limit = $cps_api->GetConversionLimits($from, $to);
        $cps_api = null;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }

    // Check for errors and add to output variable or errors array depending on success
    if ($limit['error'] == 'ok') {
        $min = $limit['result']['min'];
        $max = $limit['result']['max'];
        $output .= '<tr><td>' . $from . '</td><td>' . $to . '</td><td>' . $min . '</td><td>' . $max . '</td></tr>';
    } else {
        $errors[] = 'Error for pairing from ' . $from . ' to ' . $to . ' : ' . $limit['error'];
    }
}

// Close output HTML, check for errors and echo the output
$output .= '</tbody></table>';
if (!empty($errors)) {
    foreach ($errors as $error) {
        $output .= '<br>' . $error;
    }
}
echo $output;

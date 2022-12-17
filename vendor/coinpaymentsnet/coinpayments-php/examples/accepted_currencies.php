<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Show the currencies you accept and their exchange rates. Sample output in HTML **/

// Create a new API wrapper instance and call to the rates command.
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
try {
    $rates = $cps_api->GetRatesWithAccepted();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

if ($rates["error"] == "ok") {
    // Prepare start of sample HTML output
    $output = '<table><tbody><tr><td>Currency</td><td>BTC Conversion Rate</td></tr>';

    // Loop through the currency tickers and output the ones you accept with the BTC conversion rate
    foreach ($rates['result'] as $rate => $rate_array) {
        if ($rate_array['accepted']) {
            $output .= '<tr><td>' . $rate . '</td><td>' . $rate_array['rate_btc'] . '</td></tr>';
        }
    }

    // Close the sample output HTML and echo it onto the page
    $output .= '</tbody></table>';
    echo $output;
} else {
    echo $rates["error"];
}


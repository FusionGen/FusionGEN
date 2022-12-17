<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Show balances of all coins in account with USD conversion.**/
// Create a new API wrapper instance and call to the balances and rates commands.
try {
    $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
    $balances = $cps_api->GetAllCoinBalances();
    $cps_api = null;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
try {
    $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
    $rates = $cps_api->GetShortRates();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check for success of API calls
if ($balances['error'] == 'ok' && $rates['error'] == 'ok') {

    // Prepare arrays for storing balances
    $positive_balances = [];
    $zero_balances = [];

    // Prepare start of sample HTML output
    $output = '<table><tbody><tr><td>Currency</td><td>Satoshis Balance</td><td>Floating Point Balance</td><td>USD value</td></tr>';

    // Loop through balances and separate positive from zero balances
    foreach ($balances['result'] as $currency_balance => $balances_array) {
        if ($balances_array['balance'] > 0) {
            $positive_balances[$currency_balance] = $balances_array;
        } else {
            $zero_balances[$currency_balance] = $balances_array;
        }
    }

    // Check for positive balances and calculate the USD value for each
    if (!empty($positive_balances)) {
        $usd_to_btc = $rates['result']['USD']['rate_btc'];
        foreach ($positive_balances as $currency => $positive_balance) {
            $this_currency_to_btc = $rates['result'][$currency]['rate_btc'];
            $positive_balances[$currency]['usd_value'] = round($positive_balances[$currency]['balancef'] * ($this_currency_to_btc / $usd_to_btc), 2);
        }
    }

    // Loop through balances and add values to the output variable
    foreach ($positive_balances as $currency => $positive_balance) {
        $output .= '<tr><td>' . $currency . '</td><td>' . $positive_balance['balance'] . '</td><td>' . $positive_balance['balancef'] . '</td><td>' . $positive_balance['usd_value'] . '</td></tr>';
    }
    foreach ($zero_balances as $currency => $zero_balance) {
        $output .= '<tr><td>' . $currency . '</td><td>' . $zero_balance['balance'] . '</td><td>' . $zero_balance['balancef'] . '</td><td>0</td></tr>';
    }

    // Close the sample output HTML and echo it onto the page
    $output .= '</tbody></table>';
    echo $output;
} else {

    // Throw an error if both API calls were not successful
    echo 'Balances API call status: ' . $balances['error'] . '<br>Rates API call status: ' . $rates['error'];
}


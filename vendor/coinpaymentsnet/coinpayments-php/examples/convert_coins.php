<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Convert coins from one currency to another.
 *
 * Note that populating the amount, currency_from and currency_to variables and then loading this example will result
 * in a real attempted API call on our production platform and result in the coin conversion executing! Conversions even
 * for testing purposes cannot be reversed.
 **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Enter amount for the conversion
$amount = 0;

// Currency to convert the above amount from and to, in ticker format (BTC, LTC, etc.)
$currency_from = '';
$currency_to = '';

// The address to send the funds to.
// If blank or not included the coins will go to your CoinPayments Wallet.
// Include the following variable as the fourth parameter in ConvertCoins if you wish to specify an address.
// $address = '';

// Make sure the conversion is supported and the amount you're attempting to convert is within the conversion limits
try {
    $conversion_support = $cps_api->GetConversionLimits($currency_from, $currency_to);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check result of the API call for conversion support and limits
if ($conversion_support['error'] == 'ok') {

    // See if the amount being attempted for conversion is within the minimum and maximum
    if ($amount >= $conversion_support['result']['min'] && $amount <= $conversion_support['result']['max']) {

        // Make call to API to create the coin conversion
        try {
            $conversion = $cps_api->ConvertCoins($amount, $currency_from, $currency_to);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }

        // Check result of the API call for executing the coin conversion
        if ($conversion['error'] == 'ok') {
            // Success!
            $output = 'Conversion created with ID: ' . $conversion['result']['id'];
        } else {
            // Something went wrong!
            $output = 'Error converting coins: ' . $conversion['error'];
        }
    } else {
        $output = 'The amount of currency "' . $currency_from . '" is not within the minimum (' . $conversion_support['result']['min'] . ') and maximum (' . $conversion_support['result']['max'] . ') limits for conversion. Please adjust your amount and try again or try a different conversion pairing.';
    }
} else {
    // Something went wrong!
    $output = 'Error for converting that currency pairing: ' . $conversion_support['error'];
}

// Output the response of the API call
echo $output;

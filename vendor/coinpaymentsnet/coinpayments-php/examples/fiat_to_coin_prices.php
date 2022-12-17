<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Show fiat currency price next to multiple coin currency prices. Sample output in HTML **/

// Create a new API wrapper instance and call to the rates command.
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
try {
    $rates = $cps_api->GetShortRates();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

if ($rates["error"] == "ok") {
    // The ticker of the fiat currency.
    $fiat_currency = 'USD';

    // Uncomment the following line to see calculation for a fiat currency we do not support.
    // $fiat_currency = 'KHR';

    // The original fiat price of your product or service in USD.
    $fiat_price = 50.00;

    // The coin currency tickers to convert the price to from the fiat currency.
    // In this case we have Bitcoin, Litecoin and Ripple.
    $coin_currencies = ['BTC', 'LTC', 'XRP'];

    // Prepare start of sample HTML output
    $output = '<table><tbody><tr><td>Currency</td><td>Price</td></tr>';
    $output .= '<tr><td>' . $fiat_currency . '</td><td>' . $fiat_price . '</td></tr>';

    // Check if the fiat currency is in the rates result then calculate BTC price.
    // See supported fiat currencies here: https://www.coinpayments.net/supported-coins-fiat
    if (!empty($rates['result'][$fiat_currency])) {
        $fiat_to_btc = $rates['result'][$fiat_currency]['rate_btc'];
        $price_in_btc = ($fiat_price * $fiat_to_btc);
    } else {
        /**
         * No rate available for that fiat currency. Through manual population of the USD rate
         * for your chosen currency, you can still output coin currency prices.
         * This example uses the Cambodian Riel (KHR). At the time of this example the exchange rate of
         * 1 KHR to 1 USD was 0.000245585 so that is the value we'll use below.
         */
        $custom_fiat_to_usd = 0.000245585; // Set only this value.

        // Use USD as a baseline BTC rate to determine our custom fiat currency to BTC rate
        $usd_to_btc = $rates['result']['USD']['rate_btc'];
        $price_in_usd = ($fiat_price * $custom_fiat_to_usd);
        $price_in_btc = ($price_in_usd * $usd_to_btc);
    }

    // Loop through the currency tickers and output the price for each currency
    foreach ($coin_currencies as $currency) {
        $this_currency_rate_btc = $rates['result'][$currency]['rate_btc'];
        $this_currency_price = ($price_in_btc / $this_currency_rate_btc);
        $output .= '<tr><td>' . $currency . '</td><td>' . $this_currency_price . '</td></tr>';
    }

    // Close the sample output HTML and echo it onto the page
    $output .= '</tbody></table>';
    echo $output;
} else {
    echo $rates["error"];
}


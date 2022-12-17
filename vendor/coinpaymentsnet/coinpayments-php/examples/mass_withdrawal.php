<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Create a mass withdrawal, demonstrating different values for each withdrawal. **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Setup the withdrawals array values, each as a nested array with it's own unique key.
// The key can contain ONLY a-z, A-Z, and 0-9.
// Withdrawals with empty keys or containing other characters will be silently ignored.
$withdrawals = [
    'wd1' => [
        'amount' => 5,
        'add_tx_fee' => 0,
        'currency' => 'LTCT',
        'currency2' => 'XRP',
        'address' => 'fakeAddressForDemonstration',
        'note' => 'Testing the note field'
    ],
    'wd2' => [
        'amount' => 10,
        'add_tx_fee' => 1,
        'currency' => 'LTCT',
        'currency2' => 'XEM',
        'pbntag' => '$AnExamplePayByName'
    ],
    'wd3' => [
        'amount' => 15,
        'add_tx_fee' => 0,
        'currency' => 'LTCT',
        'address' => 'fakeAddressForDemonstration',
        'ipn_url' => 'https://a-custom-ipn-url.com/ipn_handler_script.php'
    ]
];

// Attempt the mass withdrawal API call
try {
    $mass_withdrawal = $cps_api->CreateMassWithdrawal($withdrawals);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check the result of the API call and generate a result output
if ($mass_withdrawal["error"] == "ok") {
    $output = '<table><tbody><tr><td>Withdrawal Key</td><td>Error?</td><td>ID</td><td>Status</td><td>Amount</td></tr>';
    foreach ($mass_withdrawal['result'] as $single_withdrawal_result => $single_withdrawal_result_array) {
        if ($single_withdrawal_result_array['error'] == 'ok') {
            $this_id = $single_withdrawal_result_array['id'];
            $this_status = $single_withdrawal_result_array['status'];
            $this_amount = $single_withdrawal_result_array['amount'];
            $output .= '<tr><td>' . $single_withdrawal_result . '</td><td>ok</td><td>' . $this_id . '</td><td>' . $this_status . '</td><td>' . $this_amount . '</td></tr>';
        } else {
            $this_error = $single_withdrawal_result_array['error'];
            $output .= '<tr><td>' . $single_withdrawal_result . '</td><td>' . $this_error . '</td><td>n/a</td><td>n/a</td><td>n/a</td></tr>';
        }
    }
    $output .= '</tbody></table>';
    echo $output;
} else {
    echo $mass_withdrawal["error"];
}

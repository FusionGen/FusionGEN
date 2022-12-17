<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Retrieve a history of withdrawals.  **/

// Create a new API wrapper instance
$cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

// Attempt the withdrawal history API call for the 10 most recent withdrawals.
try {
    $withdrawal_history = $cps_api->GetWithdrawalHistory(10, 0, 0);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check the result of the API call and generate a result output
if ($withdrawal_history["error"] == "ok") {
    $output = '<table><tbody><tr><td>Withdrawal ID</td><td>Coin</td><td>Amount (Satoshis)</td><td>Status</td></tr>';
    foreach ($withdrawal_history['result'] as $single_withdrawal) {
        $withdrawal_id = $single_withdrawal['id'];
        $withdrawal_coin = $single_withdrawal['coin'];
        $withdrawal_amount = $single_withdrawal['amount'];
        $withdrawal_status = $single_withdrawal['status_text'];
        $output .= '<tr><td>' . $withdrawal_id . '</td><td>' . $withdrawal_coin . '</td><td>' . $withdrawal_amount . '</td><td>' . $withdrawal_status . '</td></tr>';
    }
    $output .= '</tbody></table>';
    echo $output;
} else {
    echo $withdrawal_history["error"];
}

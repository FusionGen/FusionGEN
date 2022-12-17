<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

/** Scenario: Update $PayByName Profile information.**/
// Create a new API wrapper instance and call to the update PBN profile command.
try {
    $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

    // Populate the following profile fields
    $name = '';
    $email = '';
    $url = '';

    // Image pulled from keys file
    $image = base64_encode(file_get_contents(API_TESTS_PBN_UPDATE_IMG));

    // The update profile API call
    $tag_update = $cps_api->UpdateTagProfile(API_TESTS_PBN_UPDATE_ID, $name, $email, $url, $image);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check for success of API call
if ($tag_update['error'] == 'ok') {
    echo 'PBN tag profile updated!';
} else {
    // Throw an error if both API calls were not successful
    echo 'There was an error returned by the API call: ' . $balances['error'] . '<br>Rates API call status: ' . $rates['error'];
}

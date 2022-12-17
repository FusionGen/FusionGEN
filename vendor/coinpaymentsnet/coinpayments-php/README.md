# CoinPayments.net PHP API Wrapper.
## Requirements
It's recommended to use a newer version of PHP. This library was written in a PHP v7.2.8-1+ environment. The minimum version we've tested the code against is PHP v 5.5+. Our PHP version compatibility test used a combination of [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [PHP Compatability](https://github.com/PHPCompatibility/PHPCompatibility).

A CoinPayments.net account with an API keys pair setup (public & private). For the latest instructions visit our [online API documentation](https://www.coinpayments.net/apidoc-intro) to learn how to setup your API Keys and get a link to your account API Keys page.

See the testing section below for additional requirements to test certain commands with LTCT or mainnet coins.

Note this wrapper assumes the format requested for API responses is JSON. The alternative is XML but the XML format is not documented or supported by this wrapper. By default every API call will return JSON unless otherwise specified.

## Installation
**GitHub**

This CoinPayments.net API wrapper can be downloaded directly or cloned with GitHub. To use it in your project either clone this repository or download a ZIP to the directory of your choosing.

The minimum files required for usage are those in the source folder, `CoinpaymentsAPI.php`, `CoinpaymentsValidator.php` and `CoinpaymentsCurlRequest.php`. A 4th required file for usage of predefined API keys and testing variables is `keys.php`. There is a `keys_example.php` file which can be populated and renamed to `keys.php`. This keys file is used to pass your public and private API keys to the wrapper in order to make calls to the Coinpayments.net Platform. You can also manually pass your keys to the `CoinpaymentsAPI` class if you prefer, instead of using a `keys.php` file. The `keys.php` file should be placed in the `/src` directory.

**Composer**

To install with composer run the following command `composer require coinpaymentsnet/coinpayments-php` and then include the following line in your project where you want to use the wrapper's classes.

```php
require_once('your_project_path_to/vendor/autoload.php');
``` 

Note the `/examples` directory does not use composer autoloading. 

When using composer to autoload classes you should define your `keys.php` file outside of your `vendor` directory, as not to overwrite it when upgrading packages.

[Packagist.org package URL](https://packagist.org/packages/coinpaymentsnet/coinpayments-php)

### Examples
Previewing the scripts in the `/examples` directory in your browser is possible once you have setup the public and private keys in the `keys.php` file. This obviously requires the ability to serve these example PHP files with a web server like Apache. See additional testing notes below for interacting with these examples and your account. Some examples require you to populate initial variables in the example file in order to execute the scripts found within.

## Usage
The simplest example is retrieving basic account information. 

```php
// For manual wrapper usage include the following require:
require('/your_installation_path_to/src/CoinpaymentsAPI.php');

/** Scenario: Retrieve basic user account information.**/
// Either include the sample keys.php file (once populated) or manually set $public_key and $private_key variables
require('/your_installation_path_to/src/keys.php');

// Create a new API wrapper instance and call to the get basic account information command.
try {
    $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
    $information = $cps_api->GetBasicInfo();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check for success of API call
if ($cps_api['error'] == 'ok') {
    // Prepare start of sample HTML output
    $output = '<table><tbody><tr><td>Username</td><td>Merchant ID</td><td>Email</td><td>Public Name</td></tr>';
    $output .= '<tr><td>' . $cps_api['result']['username'] . '</td><td>' . $cps_api['result']['merchant_id'] . '</td><td>' . $cps_api['result']['email'] . '</td><td>' . $cps_api['result']['public_name'] . '</td></tr>';
    // Close the sample output HTML and echo it onto the page
    $output .= '</tbody></table>';
    echo $output;
} else {
    // Throw an error if both API calls were not successful
    echo 'There was an error returned by the API call: ' . $balances['error'] . '<br>Rates API call status: ' . $rates['error'];
}
```

## Testing
A full population of the `keys.php` file is required in order to run the `PHPUnit` tests in the test folder and preview the scripts in the `/examples` directory. The different requirements for testing commands are described below with the commands shown in the format:
 * <em>`raw_api_command_name` | `wrapperFunctionName()`</em>

With only the public and private keys populated, the following commands can be tested. Balances and deposit addresses require their respective resources to have been deposited (funds), updated (coin acceptance settings) or created (addresses) on your CoinPayments.net account in order for their commands to return non-empty results. 
* `get_basic_info` | `GetBasicInfo()`
* `rates` | `GetRates()`, `GetRatesWithAccepted()`, `GetShortRates()`, `GetShortRatesWithAccepted`
* `balances` | `GetCoinBalances()`, `GetAllCoinBalances()`
* `get_deposit_address` | `GetDepositAddress()`
* `get_callback_address` | `GetOnlyCallbackAddress()`, `GetCallbackAddressWithIpn()`
* `convert_limits` | `GetConversionLimits()`

Note that the `get_callback_address` command and functions above would also need an IPN URL setup in your account or passed with the command should you wish to test your server being notified of payment to the returned address. More information is available here in our [documentation for the Instant Payment Notification system](https://www.coinpayments.net/merchant-tools-ipn).
 
 The additional variables (those below the API keys) require setting up a second developer CoinPayments.net account to test the following commands, assuming the currency is LTCT. Alternatively these commands could also be tested with access other addresses or wallets capable of receiving and sending the currency you are testing with, as long as that currency is supported by the CoinPayments.net platform. See [supported coins here](https://www.coinpayments.net/supported-coins). 
 * `create_transaction` | `CreateSimpleTransaction()`, `CreateSimpleTransactionWithConversion()`, `CreateComplexTransaction()`, `CreateCustomTransaction()`
 * `create_transfer` | `CreateMerchantTransfer()`
 * `get_withdrawal_history` | `GetWithdrawalHistory()`
 * `get_withdrawal_info` | `GetWithdrawalInformation()` 
 * `create_withdrawal` & `create_mass_withdrawal` | `CreateWithdrawal()` & `CreateMassWithdrawal()` * using address only, not $PayByName, see below.

 Currently our API does not allow for testing of the coin conversion or $PayByName commands without access to production assets, so the following commands do require production environment data on the platform to be available. For example unclaimed and claimed $PayByName tags or currency in two convertible coins. These tests have been run by our development team with the production environment data (assets) to include these commands in code testing coverage. It is still recommended these commands be tested with the production environment before being published as part of any integration. This would require small amounts of mainnet coins for converting and the purchase of at least one $PayByName tag to claim, send funds to and retrieve information on (for the testing of all possible commands).
 * `convert` | `ConvertCoins()`
 * `get_conversion_info` | `GetConversionInformation()`
 * `get_pbn_info` | `GetProfileInformation()`
 * `get_pbn_list` | `GetTagList()`
 * `update_pbn_tag` | `UpdateTagProfile()`
 * `claim_pbn_tag` | `ClaimPayByNameTag()`
 * `create_transfer` | `CreatePayByNameTransfer()`
 * `create_withdrawal` & `create_mass_withdrawal` | `CreateWithdrawal()` & `CreateMassWithdrawal()` * using $PayByName instead of address

### PHPUnit tests
To run the tests from the `/tests` directory, run this command:
`phpunit CoinpaymentsAPITest` with your chosen flags for output type. Alternatively you can configure an IDE, like PHPStorm to run the tests in `CoinpaymentsAPITest.php` for you. In development of this wrapper we used PHPUnit v7.3.1. 

### Transaction Fees
 Test transactions done with any mainnet coin incur regular transaction and network fees, which is why we highly recommend using LiteCoin Testnet (LTCT) when testing your API integration.

## Contributing
If during your work with this wrapper you encounter a bug or have a suggestion to help improve it for others, you are welcome to open a Github issue on this repository and it will be reviewed by one of our development team members. The CoinPayments.net bug bounty does not cover this wrapper.

## License
MIT - see LICENSE.md

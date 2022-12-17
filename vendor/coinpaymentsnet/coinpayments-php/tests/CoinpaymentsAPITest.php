<?php
require('../src/Coinpayments.php');
require('../src/keys.php');

use PHPUnit\Framework\TestCase;

class CoinpaymentsAPITest extends TestCase
{
    private $api;

    protected function setUp()
    {
        $this->api = new CoinpaymentsAPI(API_PRIVATE_KEY, API_PUBLIC_KEY, 'json');
    }

    /**
     * A reusable check for the format of the API call response object.
     *
     * @param $test Instance of test method.
     * @param $response Response object from API call.
     */
    public function checkResponseFormat($test, $response)
    {
        $test->assertArrayHasKey('error', $response);
        $test->assertEquals('ok', $response['error']);
        $test->assertArrayHasKey('result', $response);
        $test->assertNotEmpty($response['result']);
    }

    /**
     * @covers CoinPaymentsAPI::__construct
     * @expectedException ArgumentCountError
     */
    public function testEmptySetupofApiInstance()
    {
        $this->api = new CoinpaymentsAPI();
    }

    /**
     * @covers CoinPaymentsAPI::__construct
     * @expectedException ArgumentCountError
     */
    public function testOnlyOneKeySetupofApiInstance()
    {
        $this->failed_api_one_key = new CoinpaymentsAPI('key');
    }

    /**
     * @covers CoinPaymentsAPI::__construct
     */
    public function testProperSetupOfApiInstance()
    {
        $this->assertInstanceOf(CoinpaymentsAPI::class, $this->api);
        $this->assertObjectHasAttribute('request_handler', $this->api);
        $this->assertAttributeInstanceOf(CoinpaymentsCurlRequest::class, 'request_handler', $this->api);
    }

    /**
     * @covers CoinPaymentsAPI::getBasicInfo
     */
    public function testGetBasicInfo()
    {
        $response = $this->api->GetBasicInfo();
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('username', $response['result']);
        $this->assertInternalType('string', $response['result']['username']);
        $this->assertArrayHasKey('merchant_id', $response['result']);
        $this->assertInternalType('string', $response['result']['merchant_id']);
        $this->assertArrayHasKey('email', $response['result']);
        $this->assertInternalType('string', $response['result']['email']);
        $this->assertArrayHasKey('public_name', $response['result']);
        $this->assertInternalType('string', $response['result']['public_name']);
    }

    /**
     * @covers CoinPaymentsAPI::getRates
     *
     * Note this test randomly checks any one of the returned rate values.
     */
    public function testGetRates()
    {
        $response = $this->api->GetRates();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_rate = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_rate);
        $this->assertNotEmpty($random_rate);
        $this->assertArrayHasKey('is_fiat', $random_rate);
        $this->assertInternalType('integer', $random_rate['is_fiat']);
        $this->assertArrayHasKey('rate_btc', $random_rate);
        $this->assertInternalType('string', $random_rate['rate_btc']);
        $this->assertArrayHasKey('last_update', $random_rate);
        $this->assertInternalType('string', $random_rate['last_update']);
        $this->assertArrayHasKey('tx_fee', $random_rate);
        $this->assertInternalType('string', $random_rate['tx_fee']);
        $this->assertArrayHasKey('status', $random_rate);
        $this->assertInternalType('string', $random_rate['status']);
        $this->assertArrayHasKey('name', $random_rate);
        $this->assertInternalType('string', $random_rate['name']);
        $this->assertArrayHasKey('confirms', $random_rate);
        $this->assertInternalType('string', $random_rate['confirms']);
        $this->assertArrayHasKey('can_convert', $random_rate);
        $this->assertInternalType('integer', $random_rate['can_convert']);
        $this->assertArrayHasKey('capabilities', $random_rate);
        $this->assertInternalType('array', $random_rate['capabilities']);
    }

    /**
     * @covers CoinPaymentsAPI::GetRatesWithAccepted
     *
     * Note this test randomly checks any one of the returned rate values.
     */
    public function testGetRatesWithAccepted()
    {
        $response = $this->api->GetRatesWithAccepted();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_rate = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_rate);
        $this->assertNotEmpty($random_rate);
        $this->assertArrayHasKey('is_fiat', $random_rate);
        $this->assertInternalType('integer', $random_rate['is_fiat']);
        $this->assertArrayHasKey('rate_btc', $random_rate);
        $this->assertInternalType('string', $random_rate['rate_btc']);
        $this->assertArrayHasKey('last_update', $random_rate);
        $this->assertInternalType('string', $random_rate['last_update']);
        $this->assertArrayHasKey('tx_fee', $random_rate);
        $this->assertInternalType('string', $random_rate['tx_fee']);
        $this->assertArrayHasKey('status', $random_rate);
        $this->assertInternalType('string', $random_rate['status']);
        $this->assertArrayHasKey('name', $random_rate);
        $this->assertInternalType('string', $random_rate['name']);
        $this->assertArrayHasKey('confirms', $random_rate);
        $this->assertInternalType('string', $random_rate['confirms']);
        $this->assertArrayHasKey('can_convert', $random_rate);
        $this->assertInternalType('integer', $random_rate['can_convert']);
        $this->assertArrayHasKey('capabilities', $random_rate);
        $this->assertInternalType('array', $random_rate['capabilities']);
        $this->assertArrayHasKey('accepted', $random_rate);
        $this->assertInternalType('integer', $random_rate['accepted']);
    }

    /**
     * @covers CoinPaymentsAPI::GetShortRates
     *
     * Note this test randomly checks any one of the returned rate values.
     */
    public function testGetShortRates()
    {
        $response = $this->api->GetShortRates();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_rate = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_rate);
        $this->assertNotEmpty($random_rate);
        $this->assertArrayHasKey('is_fiat', $random_rate);
        $this->assertInternalType('integer', $random_rate['is_fiat']);
        $this->assertArrayHasKey('rate_btc', $random_rate);
        $this->assertInternalType('string', $random_rate['rate_btc']);
        $this->assertArrayHasKey('last_update', $random_rate);
        $this->assertInternalType('string', $random_rate['last_update']);
        $this->assertArrayHasKey('tx_fee', $random_rate);
        $this->assertInternalType('string', $random_rate['tx_fee']);
        $this->assertArrayHasKey('status', $random_rate);
        $this->assertInternalType('string', $random_rate['status']);

    }

    /**
     * @covers CoinPaymentsAPI::GetShortRatesWithAccepted
     *
     * Note this test randomly checks any one of the returned rate values.
     */
    public function testGetShortRatesWithAccepted()
    {
        $response = $this->api->GetShortRatesWithAccepted();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_rate = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_rate);
        $this->assertNotEmpty($random_rate);
        $this->assertArrayHasKey('is_fiat', $random_rate);
        $this->assertInternalType('integer', $random_rate['is_fiat']);
        $this->assertArrayHasKey('rate_btc', $random_rate);
        $this->assertInternalType('string', $random_rate['rate_btc']);
        $this->assertArrayHasKey('last_update', $random_rate);
        $this->assertInternalType('string', $random_rate['last_update']);
        $this->assertArrayHasKey('tx_fee', $random_rate);
        $this->assertInternalType('string', $random_rate['tx_fee']);
        $this->assertArrayHasKey('status', $random_rate);
        $this->assertInternalType('string', $random_rate['status']);
        $this->assertArrayHasKey('accepted', $random_rate);
        $this->assertInternalType('integer', $random_rate['accepted']);
    }

    /**
     * @covers CoinPaymentsAPI::GetCoinBalances
     *
     * Note this test randomly checks any one of the returned balance values.
     */
    public function testGetCoinBalances()
    {
        $response = $this->api->GetCoinBalances();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_balance = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_balance);
        $this->assertNotEmpty($random_balance);
        $this->assertArrayHasKey('balance', $random_balance);
        $this->assertInternalType('integer', $random_balance['balance']);
        $this->assertArrayHasKey('balancef', $random_balance);
        $this->assertInternalType('string', $random_balance['balancef']);
        $this->assertArrayHasKey('status', $random_balance);
        $this->assertInternalType('string', $random_balance['status']);
        $this->assertArrayHasKey('coin_status', $random_balance);
        $this->assertInternalType('string', $random_balance['coin_status']);
    }

    /**
     * @covers CoinPaymentsAPI::GetAllCoinBalances
     */
    public function testGetAllCoinBalances()
    {
        $response = $this->api->GetAllCoinBalances();
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_balance = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_balance);
        $this->assertNotEmpty($random_balance);
        $this->assertArrayHasKey('balance', $random_balance);
        $this->assertInternalType('integer', $random_balance['balance']);
        $this->assertArrayHasKey('balancef', $random_balance);
        $this->assertInternalType('string', $random_balance['balancef']);
        $this->assertArrayHasKey('status', $random_balance);
        $this->assertInternalType('string', $random_balance['status']);
        $this->assertArrayHasKey('coin_status', $random_balance);
        $this->assertInternalType('string', $random_balance['coin_status']);
    }

    /**
     * @covers CoinPaymentsAPI::GetDepositAddress
     */
    public function testGetDepositAddress()
    {
        $response = $this->api->GetDepositAddress('LTCT');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
    }

    /**
     * @covers CoinPaymentsAPI::GetDepositAddress
     */
    public function testGetDepositAddressWithPubKey()
    {
        $response = $this->api->GetDepositAddress('NXT');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('pubkey', $response['result']);
        $this->assertInternalType('string', $response['result']['pubkey']);
    }

    /**
     * @covers CoinPaymentsAPI::GetDepositAddress
     */
    public function testGetDepositAddressWithDestTag()
    {
        $response = $this->api->GetDepositAddress('XRP');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('dest_tag', $response['result']);
        $this->assertInternalType('string', $response['result']['dest_tag']);
    }

    /**
     * @covers CoinPaymentsAPI::GetOnlyCallbackAddress
     */
    public function testGetOnlyCallbackAddress()
    {
        $response = $this->api->GetOnlyCallbackAddress('LTCT');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
    }

    /**
     * @covers CoinPaymentsAPI::GetOnlyCallbackAddress
     */
    public function testGetOnlyCallbackAddressWithPubKey()
    {
        $response = $this->api->GetOnlyCallbackAddress('NXT');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('pubkey', $response['result']);
        $this->assertInternalType('string', $response['result']['pubkey']);
    }

    /**
     * @covers CoinPaymentsAPI::GetOnlyCallbackAddress
     */
    public function testGetOnlyCallbackAddressWithDestTag()
    {
        $response = $this->api->GetOnlyCallbackAddress('XRP');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('dest_tag', $response['result']);
        $this->assertInternalType('integer', $response['result']['dest_tag']);
    }

    /**
     * @covers CoinPaymentsAPI::GetCallbackAddressWithIpn
     *
     * Note the IPN URL passed is only a test example.
     * In production your IPN URL must reside on your own web server and be configured to receive notifications!
     * @link https://www.coinpayments.net/merchant-tools-ipn
     */
    public function testGetCallbackAddressWithIpn()
    {
        $response = $this->api->GetCallbackAddressWithIpn('LTCT', 'https://www.coinpayments.net/sample-ipn-address');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
    }

    /**
     * @covers CoinPaymentsAPI::GetCallbackAddressWithIpn
     *
     * Note the IPN URL passed is only a test example.
     * In production your IPN URL must reside on your own web server and be configured to receive notifications!
     * @link https://www.coinpayments.net/merchant-tools-ipn
     */
    public function testGetCallbackAddressWithIpnAndPubKey()
    {
        $response = $this->api->GetCallbackAddressWithIpn('NXT', 'https://www.coinpayments.net/sample-ipn-address');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('pubkey', $response['result']);
        $this->assertInternalType('string', $response['result']['pubkey']);
    }

    /**
     * @covers CoinPaymentsAPI::GetCallbackAddressWithIpn
     *
     * Note the IPN URL passed is only a test example.
     * In production your IPN URL must reside on your own web server and be configured to receive notifications!
     * @link https://www.coinpayments.net/merchant-tools-ipn
     */
    public function testGetCallbackAddressWithIpnAndDestTag()
    {
        $response = $this->api->GetCallbackAddressWithIpn('XRP', 'https://www.coinpayments.net/sample-ipn-address');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('dest_tag', $response['result']);
        $this->assertInternalType('integer', $response['result']['dest_tag']);
    }

    /**
     * @covers CoinPaymentsAPI::GetConversionLimits
     */
    public function testGetConversionLimits()
    {
        $response = $this->api->GetConversionLimits('BTC', 'LTC');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('min', $response['result']);
        $this->assertInternalType('string', $response['result']['min']);
        $this->assertArrayHasKey('max', $response['result']);
        $this->assertInternalType('string', $response['result']['max']);
    }

    /**
     * @covers CoinpaymentsAPI::GetTxInfoSingle
     */
    public function testGetTxInfoSingle()
    {
        $response = $this->api->GetTxInfoSingle(API_TESTS_TXID_SINGLE);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('time_created', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_created']);
        $this->assertArrayHasKey('time_expires', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_expires']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('status_text', $response['result']);
        $this->assertInternalType('string', $response['result']['status_text']);
        $this->assertArrayHasKey('type', $response['result']);
        $this->assertInternalType('string', $response['result']['type']);
        $this->assertArrayHasKey('coin', $response['result']);
        $this->assertInternalType('string', $response['result']['coin']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('integer', $response['result']['amount']);
        $this->assertArrayHasKey('amountf', $response['result']);
        $this->assertInternalType('string', $response['result']['amountf']);
        $this->assertArrayHasKey('received', $response['result']);
        $this->assertInternalType('integer', $response['result']['received']);
        $this->assertArrayHasKey('receivedf', $response['result']);
        $this->assertInternalType('string', $response['result']['receivedf']);
        $this->assertArrayHasKey('recv_confirms', $response['result']);
        $this->assertInternalType('integer', $response['result']['recv_confirms']);
        $this->assertArrayHasKey('payment_address', $response['result']);
        $this->assertInternalType('string', $response['result']['payment_address']);
        $this->assertArrayHasKey('time_completed', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_completed']);
    }

    /**
     * @covers CoinpaymentsAPI::GetTxInfoSingleWithRaw
     */
    public function testGetTxInfoSingleWithRaw()
    {
        $response = $this->api->GetTxInfoSingleWithRaw(API_TESTS_TXID_SINGLE);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('time_created', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_created']);
        $this->assertArrayHasKey('time_expires', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_expires']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('status_text', $response['result']);
        $this->assertInternalType('string', $response['result']['status_text']);
        $this->assertArrayHasKey('type', $response['result']);
        $this->assertInternalType('string', $response['result']['type']);
        $this->assertArrayHasKey('coin', $response['result']);
        $this->assertInternalType('string', $response['result']['coin']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('integer', $response['result']['amount']);
        $this->assertArrayHasKey('amountf', $response['result']);
        $this->assertInternalType('string', $response['result']['amountf']);
        $this->assertArrayHasKey('received', $response['result']);
        $this->assertInternalType('integer', $response['result']['received']);
        $this->assertArrayHasKey('receivedf', $response['result']);
        $this->assertInternalType('string', $response['result']['receivedf']);
        $this->assertArrayHasKey('recv_confirms', $response['result']);
        $this->assertInternalType('integer', $response['result']['recv_confirms']);
        $this->assertArrayHasKey('payment_address', $response['result']);
        $this->assertInternalType('string', $response['result']['payment_address']);
        $this->assertArrayHasKey('time_completed', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_completed']);
        $this->assertArrayHasKey('checkout', $response['result']);
        $this->assertInternalType('array', $response['result']['checkout']);
        $this->assertArrayHasKey('subtotal', $response['result']['checkout']);
        $this->assertInternalType('integer', $response['result']['checkout']['subtotal']);
        $this->assertArrayHasKey('tax', $response['result']['checkout']);
        $this->assertInternalType('integer', $response['result']['checkout']['tax']);
        $this->assertArrayHasKey('shipping', $response['result']['checkout']);
        $this->assertInternalType('integer', $response['result']['checkout']['shipping']);
        $this->assertArrayHasKey('total', $response['result']['checkout']);
        $this->assertInternalType('integer', $response['result']['checkout']['total']);
        $this->assertArrayHasKey('currency', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['currency']);
        $this->assertArrayHasKey('amount', $response['result']['checkout']);
        $this->assertInternalType('integer', $response['result']['checkout']['amount']);
        $this->assertArrayHasKey('item_name', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['item_name']);
        $this->assertArrayHasKey('item_number', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['item_number']);
        $this->assertArrayHasKey('invoice', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['invoice']);
        $this->assertArrayHasKey('custom', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['custom']);
        $this->assertArrayHasKey('ipn_url', $response['result']['checkout']);
        $this->assertInternalType('string', $response['result']['checkout']['ipn_url']);
        $this->assertArrayHasKey('amountf', $response['result']['checkout']);
        $this->assertInternalType('float', $response['result']['checkout']['amountf']);
        $this->assertArrayHasKey('shipping', $response['result']);
        $this->assertInternalType('array', $response['result']['shipping']);
        $this->assertArrayHasKey('first_name', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['first_name']);
        $this->assertArrayHasKey('last_name', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['last_name']);
        $this->assertArrayHasKey('company', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['company']);
        $this->assertArrayHasKey('address1', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['address1']);
        $this->assertArrayHasKey('address2', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['address2']);
        $this->assertArrayHasKey('city', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['city']);
        $this->assertArrayHasKey('state', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['state']);
        $this->assertArrayHasKey('zip', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['zip']);
        $this->assertArrayHasKey('country', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['country']);
        $this->assertArrayHasKey('phone', $response['result']['shipping']);
        $this->assertInternalType('string', $response['result']['shipping']['phone']);
    }

    /**
     * @covers CoinpaymentsAPI::GetTxInfoMulti
     */
    public function testGetTxInfoMulti()
    {
        $response = $this->api->GetTxInfoMulti(API_TESTS_TXID_MULTI);
        $this->checkResponseFormat($this, $response);
        $random_index = rand(0, (count($response['result']) - 1));
        $random_tx = array_values($response['result'])[$random_index];
        $this->assertInternalType('array', $random_tx);
        $this->assertNotEmpty($random_tx);
        $this->assertArrayHasKey('error', $random_tx);
        $this->assertInternalType('string', $random_tx['error']);
        $this->assertArrayHasKey('time_created', $random_tx);
        $this->assertInternalType('integer', $random_tx['time_created']);
        $this->assertArrayHasKey('time_expires', $random_tx);
        $this->assertInternalType('integer', $random_tx['time_expires']);
        $this->assertArrayHasKey('status', $random_tx);
        $this->assertInternalType('integer', $random_tx['status']);
        $this->assertArrayHasKey('status_text', $random_tx);
        $this->assertInternalType('string', $random_tx['status_text']);
        $this->assertArrayHasKey('type', $random_tx);
        $this->assertInternalType('string', $random_tx['type']);
        $this->assertArrayHasKey('coin', $random_tx);
        $this->assertInternalType('string', $random_tx['coin']);
        $this->assertArrayHasKey('amount', $random_tx);
        $this->assertInternalType('integer', $random_tx['amount']);
        $this->assertArrayHasKey('amountf', $random_tx);
        $this->assertInternalType('string', $random_tx['amountf']);
        $this->assertArrayHasKey('received', $random_tx);
        $this->assertInternalType('integer', $random_tx['received']);
        $this->assertArrayHasKey('receivedf', $random_tx);
        $this->assertInternalType('string', $random_tx['receivedf']);
        $this->assertArrayHasKey('recv_confirms', $random_tx);
        $this->assertInternalType('integer', $random_tx['recv_confirms']);
        $this->assertArrayHasKey('payment_address', $random_tx);
        $this->assertInternalType('string', $random_tx['payment_address']);
        $this->assertArrayHasKey('time_completed', $random_tx);
        $this->assertInternalType('integer', $random_tx['time_completed']);
    }

    /**
     * @covers CoinPaymentsAPI::GetSellerTransactionList
     */
    public function testGetSellerTransactionList()
    {
        $response = $this->api->GetSellerTransactionList();
        $this->checkResponseFormat($this, $response);
        if (count($response['result']) > 0) {
            $this->assertInternalType('string', $response['result'][0]);
        }
    }

    /**
     * @covers CoinPaymentsAPI::GetFullTransactionList
     */
    public function testGetFullTransactionList()
    {
        $response = $this->api->GetFullTransactionList();
        $this->checkResponseFormat($this, $response);
        if (count($response['result']) > 0) {
            $this->assertArrayHasKey('txid', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['txid']);
            $this->assertArrayHasKey('user_is', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['user_is']);
        }
    }

    /**
     * @covers CoinPaymentsAPI::CreateSimpleTransaction
     */
    public function testCreateSimpleTransaction()
    {
        $response = $this->api->CreateSimpleTransaction('0.001', 'LTCT', API_TESTS_BUYER_EMAIL);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
        $this->assertArrayHasKey('txn_id', $response['result']);
        $this->assertInternalType('string', $response['result']['txn_id']);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('confirms_needed', $response['result']);
        $this->assertInternalType('string', $response['result']['confirms_needed']);
        $this->assertArrayHasKey('timeout', $response['result']);
        $this->assertInternalType('integer', $response['result']['timeout']);
        $this->assertArrayHasKey('status_url', $response['result']);
        $this->assertInternalType('string', $response['result']['status_url']);
        $this->assertArrayHasKey('qrcode_url', $response['result']);
        $this->assertInternalType('string', $response['result']['qrcode_url']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateSimpleTransactionWithConversion
     */
    public function testCreateSimpleTransactionWithConversion()
    {
        $response = $this->api->CreateSimpleTransactionWithConversion('0.01', 'BTC', 'LTCT', API_TESTS_BUYER_EMAIL);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
        $this->assertArrayHasKey('txn_id', $response['result']);
        $this->assertInternalType('string', $response['result']['txn_id']);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('confirms_needed', $response['result']);
        $this->assertInternalType('string', $response['result']['confirms_needed']);
        $this->assertArrayHasKey('timeout', $response['result']);
        $this->assertInternalType('integer', $response['result']['timeout']);
        $this->assertArrayHasKey('status_url', $response['result']);
        $this->assertInternalType('string', $response['result']['status_url']);
        $this->assertArrayHasKey('qrcode_url', $response['result']);
        $this->assertInternalType('string', $response['result']['qrcode_url']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateComplexTransaction
     *
     * Note the IPN URL passed is only a test example.
     * In production your IPN URL must reside on your own web server and be configured to receive notifications!
     * @link https://www.coinpayments.net/merchant-tools-ipn
     */
    public function testCreateComplexTransaction()
    {
        $response = $this->api->CreateComplexTransaction('0.01', 'BTC', 'LTCT', API_TESTS_BUYER_EMAIL, API_TESTS_LTCT_TO, 'SampleBuyerName', 'SampleItemName', 'SampleItemNumber', 'SampleInvoice', 'SampleCustom', 'https://www.coinpayments.net/sample-ipn-address');
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
        $this->assertArrayHasKey('txn_id', $response['result']);
        $this->assertInternalType('string', $response['result']['txn_id']);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('confirms_needed', $response['result']);
        $this->assertInternalType('string', $response['result']['confirms_needed']);
        $this->assertArrayHasKey('timeout', $response['result']);
        $this->assertInternalType('integer', $response['result']['timeout']);
        $this->assertArrayHasKey('status_url', $response['result']);
        $this->assertInternalType('string', $response['result']['status_url']);
        $this->assertArrayHasKey('qrcode_url', $response['result']);
        $this->assertInternalType('string', $response['result']['qrcode_url']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateCustomTransaction
     */
    public function testCreateCustomTransaction()
    {
        $fields = [
            'amount' => '0.01',
            'currency1' => 'BTC',
            'currency2' => 'LTCT',
            'buyer_email' => API_TESTS_BUYER_EMAIL,
            'address' => API_TESTS_LTCT_TO,
            'custom' => 'SampleCustom'
        ];
        $response = $this->api->CreateCustomTransaction($fields);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
        $this->assertArrayHasKey('txn_id', $response['result']);
        $this->assertInternalType('string', $response['result']['txn_id']);
        $this->assertArrayHasKey('address', $response['result']);
        $this->assertInternalType('string', $response['result']['address']);
        $this->assertArrayHasKey('confirms_needed', $response['result']);
        $this->assertInternalType('string', $response['result']['confirms_needed']);
        $this->assertArrayHasKey('timeout', $response['result']);
        $this->assertInternalType('integer', $response['result']['timeout']);
        $this->assertArrayHasKey('status_url', $response['result']);
        $this->assertInternalType('string', $response['result']['status_url']);
        $this->assertArrayHasKey('qrcode_url', $response['result']);
        $this->assertInternalType('string', $response['result']['qrcode_url']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateMerchantTransfer
     */
    public function testCreateMerchantTransfer()
    {
        $response = $this->api->CreateMerchantTransfer('0.01', 'LTCT', API_TESTS_ALT_MID);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('id', $response['result']);
        $this->assertInternalType('string', $response['result']['id']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
    }

    /**
     * @covers CoinpaymentsAPI::CreatePayByNameTransfer
     */
    public function testCreatePayByNameTransfer()
    {
        $response = $this->api->CreatePayByNameTransfer('0.01', 'LTCT', API_TESTS_PBN);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('id', $response['result']);
        $this->assertInternalType('string', $response['result']['id']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
    }

    /**
     * @covers CoinPaymentsAPI::GetWithdrawalHistory
     *
     * Note: Does not check for send_dest_tag since withdrawal ID passed
     * is not known ahead of time to be for a destination tag currency.
     */
    public function testGetWithdrawalHistory()
    {
        $response = $this->api->GetWithdrawalHistory();
        $this->checkResponseFormat($this, $response);
        if (count($response['result']) > 0) {
            $this->assertArrayHasKey('id', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['id']);
            $this->assertArrayHasKey('time_created', $response['result'][0]);
            $this->assertInternalType('integer', $response['result'][0]['time_created']);
            $this->assertArrayHasKey('status', $response['result'][0]);
            $this->assertInternalType('integer', $response['result'][0]['status']);
            $this->assertArrayHasKey('status_text', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['status_text']);
            $this->assertArrayHasKey('coin', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['coin']);
            $this->assertArrayHasKey('amount', $response['result'][0]);
            $this->assertInternalType('integer', $response['result'][0]['amount']);
            $this->assertArrayHasKey('amountf', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['amountf']);
            $this->assertArrayHasKey('send_address', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['send_address']);
            $this->assertArrayHasKey('send_txid', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['send_txid']);
        }
    }

    /**
     * @covers CoinPaymentsAPI::GetWithdrawalInformation
     */
    public function testGetWithdrawalInformation()
    {
        $response = $this->api->GetWithdrawalInformation(API_TESTS_WID);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('time_created', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_created']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('status_text', $response['result']);
        $this->assertInternalType('string', $response['result']['status_text']);
        $this->assertArrayHasKey('coin', $response['result']);
        $this->assertInternalType('string', $response['result']['coin']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('integer', $response['result']['amount']);
        $this->assertArrayHasKey('amountf', $response['result']);
        $this->assertInternalType('string', $response['result']['amountf']);
        $this->assertArrayHasKey('send_address', $response['result']);
        $this->assertInternalType('string', $response['result']['send_address']);
        $this->assertArrayHasKey('send_txid', $response['result']);
        $this->assertInternalType('string', $response['result']['send_txid']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateWithdrawal
     */
    public function testCreateWithdrawal()
    {
        $fields = [
            'amount' => '0.01',
            'currency' => 'LTCT',
            'pbntag' => API_TESTS_PBN,
            'note' => 'SampleNote'
        ];
        $response = $this->api->CreateWithdrawal($fields);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('id', $response['result']);
        $this->assertInternalType('string', $response['result']['id']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('amount', $response['result']);
        $this->assertInternalType('string', $response['result']['amount']);
    }

    /**
     * @covers CoinPaymentsAPI::CreateMassWithdrawal
     */
    public function testCreateMassWithdrawal()
    {
        $withdrawals = [
            'wd1' => [
                'amount' => 0.02,
                'currency' => 'LTCT',
                'pbntag' => API_TESTS_PBN,
                'note' => 'SampleNote'
            ],
            'wd2' => [
                'amount' => 0.03,
                'currency' => 'LTCT',
                'pbntag' => API_TESTS_PBN
            ]
        ];
        $response = $this->api->CreateMassWithdrawal($withdrawals);
        $this->checkResponseFormat($this, $response);
        if (count($response['result']) > 0) {
            $this->assertArrayHasKey('error', $response['result']['wd1']);
            $this->assertInternalType('string', $response['result']['wd1']['error']);
            $this->assertArrayHasKey('id', $response['result']['wd1']);
            $this->assertInternalType('string', $response['result']['wd1']['id']);
            $this->assertArrayHasKey('status', $response['result']['wd1']);
            $this->assertInternalType('integer', $response['result']['wd1']['status']);
            $this->assertArrayHasKey('amount', $response['result']['wd1']);
            $this->assertInternalType('string', $response['result']['wd1']['amount']);
        }
    }

    /**
     * @covers CoinpaymentsAPI::GetProfileInformation
     */
    public function testGetProfileInformation()
    {
        $response = $this->api->GetProfileInformation(API_TESTS_PBN);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('pbntag', $response['result']);
        $this->assertInternalType('string', $response['result']['pbntag']);
        $this->assertArrayHasKey('merchant', $response['result']);
        $this->assertInternalType('string', $response['result']['merchant']);
        $this->assertArrayHasKey('profile_name', $response['result']);
        $this->assertInternalType('string', $response['result']['profile_name']);
        $this->assertArrayHasKey('profile_url', $response['result']);
        $this->assertInternalType('string', $response['result']['profile_url']);
        $this->assertArrayHasKey('profile_email', $response['result']);
        $this->assertInternalType('string', $response['result']['profile_email']);
        $this->assertArrayHasKey('profile_image', $response['result']);
        $this->assertInternalType('string', $response['result']['profile_image']);
        $this->assertArrayHasKey('member_since', $response['result']);
        $this->assertInternalType('integer', $response['result']['member_since']);
        $this->assertArrayHasKey('feedback', $response['result']);
        $this->assertInternalType('array', $response['result']['feedback']);
        if (count($response['result']['feedback']) > 0) {
            $this->assertArrayHasKey('pos', $response['result']['feedback']);
            $this->assertInternalType('integer', $response['result']['feedback']['pos']);
            $this->assertArrayHasKey('neg', $response['result']['feedback']);
            $this->assertInternalType('integer', $response['result']['feedback']['neg']);
            $this->assertArrayHasKey('neut', $response['result']['feedback']);
            $this->assertInternalType('integer', $response['result']['feedback']['neut']);
            $this->assertArrayHasKey('total', $response['result']['feedback']);
            $this->assertInternalType('integer', $response['result']['feedback']['total']);
            $this->assertArrayHasKey('percent', $response['result']['feedback']);
            $this->assertInternalType('string', $response['result']['feedback']['percent']);
            $this->assertArrayHasKey('percent_str', $response['result']['feedback']);
            $this->assertInternalType('string', $response['result']['feedback']['percent_str']);
        }
    }

    /**
     * @covers CoinpaymentsAPI::GetTagList
     */
    public function testGetTagList()
    {
        $response = $this->api->GetTagList();
        $this->checkResponseFormat($this, $response);
        if (count($response['result']) > 0) {
            $this->assertArrayHasKey('tagid', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['tagid']);
            $this->assertArrayHasKey('pbntag', $response['result'][0]);
            $this->assertInternalType('string', $response['result'][0]['pbntag']);
            $this->assertArrayHasKey('time_expires', $response['result'][0]);
            $this->assertInternalType('integer', $response['result'][0]['time_expires']);
        }
    }

    /**
     * @covers CoinpaymentsAPI::UpdateTagProfile
     */
    public function testUpdateTagProfile(){
        $image = base64_encode(file_get_contents(API_TESTS_PBN_UPDATE_IMG));
        $response = $this->api->UpdateTagProfile(API_TESTS_PBN_UPDATE_ID, 'SampleName', 'notareal@email.com', 'https://www.google.com', $image);
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('ok', $response['error']);
    }

    /**
     * Production Asset Tests
     *
     * Note that the following tests require production assets to be available in the
     * account that you've connected to with public and private keys from keys.php.
     *
     * The variables in keys.php required to be set are:
     *      - $convert_from (string) Currency ticker, for example: BTC
     *      - $convert_to (string) Currency ticker of a supported coin conversion from the $convert_from currency.
     *      - $convert_amount (integer) The amount of $currency_from to convert.
     *      - $conversion_id (string) The ID of a previous coin conversion to lookup information on.
     *      - $empty_pbn_tag_id (string) The tag ID of an unused $PayByName used to claim a name.
     *      - $new_pbn_tag_name (string) The name of the $PayByName tag that will be claimed when running the test for the 'claim_pbn_tag' API command.
     */

    /**
     * @covers CoinpaymentsAPI::ConvertCoins
     */
    public function testConvertCoins()
    {
        $response = $this->api->ConvertCoins(API_TESTS_CONVERT_AMOUNT, API_TESTS_CONVERT_FROM, API_TESTS_CONVERT_TO);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('id', $response['result']);
        $this->assertInternalType('string', $response['result']['id']);
    }

    /**
     * @covers CoinpaymentsAPI::GetConversionInformation
     */
    public function testGetConversionInformation()
    {
        $response = $this->api->GetConversionInformation(API_TESTS_CONVERSION_ID);
        $this->checkResponseFormat($this, $response);
        $this->assertArrayHasKey('time_created', $response['result']);
        $this->assertInternalType('integer', $response['result']['time_created']);
        $this->assertArrayHasKey('status', $response['result']);
        $this->assertInternalType('integer', $response['result']['status']);
        $this->assertArrayHasKey('status_text', $response['result']);
        $this->assertInternalType('string', $response['result']['status_text']);
        $this->assertArrayHasKey('coin1', $response['result']);
        $this->assertInternalType('string', $response['result']['coin1']);
        $this->assertArrayHasKey('coin2', $response['result']);
        $this->assertInternalType('string', $response['result']['coin2']);
        $this->assertArrayHasKey('amount_sent', $response['result']);
        $this->assertInternalType('integer', $response['result']['amount_sent']);
        $this->assertArrayHasKey('amount_sentf', $response['result']);
        $this->assertInternalType('string', $response['result']['amount_sentf']);
        $this->assertArrayHasKey('received', $response['result']);
        $this->assertInternalType('integer', $response['result']['received']);
        $this->assertArrayHasKey('receivedf', $response['result']);
        $this->assertInternalType('string', $response['result']['receivedf']);
    }

    /**
     * @covers CoinpaymentsAPI::ClaimPayByNameTag
     */
    public function testClaimPayByNameTag()
    {
        $response = $this->api->ClaimPayByNameTag(API_TESTS_PBN_EMPTY_ID, API_TESTS_NEW_PBN_NAME);
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('ok', $response['error']);
        $this->assertArrayHasKey('result', $response);
        $this->assertEmpty($response['result']);
    }

    /**
     * Method called after every test to set API handler to null.
     */
    public function tearDown()
    {
        $this->api = null;
    }

}

<?php
require('../src/CoinpaymentsCurlRequest.php');
require('../src/keys.php');

use PHPUnit\Framework\TestCase;

class CoinPaymentsCurlRequestTest extends TestCase
{
    private $curl_test;
    private $private_key = API_PRIVATE_KEY;
    private $public_key = API_PUBLIC_KEY;
    private $format = 'json';

    /**
     * Method called before every test.
     */
    protected function setUp()
    {
        $this->curl_test = new CoinpaymentsCurlRequest($this->private_key, $this->public_key, $this->format);
    }

    /**
     * @covers CoinpaymentsCurlRequest::__construct
     */
    public function testInit()
    {
        $this->assertInstanceOf(CoinpaymentsCurlRequest::class, $this->curl_test);
        $this->assertObjectHasAttribute('private_key', $this->curl_test);
        $this->assertObjectHasAttribute('public_key', $this->curl_test);
        $this->assertObjectHasAttribute('format', $this->curl_test);
    }

    /**
     * @covers CoinpaymentsCurlRequest::__construct
     * @expectedException ArgumentCountError
     */
    public function testEmptyInit()
    {
        $this->empty_curl_test = new CoinpaymentsCurlRequest();
    }

    /**
     * @covers CoinpaymentsCurlRequest::__construct
     * @expectedException ArgumentCountError
     */
    public function testPartialInit()
    {
        $this->empty_curl_test = new CoinpaymentsCurlRequest('key');
    }

    /**
     * @covers CoinpaymentsCurlRequest::execute
     * @expectedException ArgumentCountError
     */
    public function testEmptyExecute()
    {
        $response = $this->curl_test->execute();
    }

    /**
     * @covers CoinpaymentsCurlRequest::execute
     */
    public function testExecute()
    {
        $response = $this->curl_test->execute('get_basic_info');
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('ok', $response['error']);
        $this->assertArrayHasKey('result', $response);
        $this->assertNotEmpty($response['result']);
    }

    /**
     * Method called after every test to set API handler to null.
     */
    public function tearDown()
    {
        $this->curl_test = null;
    }
}

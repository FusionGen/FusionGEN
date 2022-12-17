<?php

defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

//API Container
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;

//API Functions
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PayPalConnectionException;

class Paypal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->config("donate");
        $this->load->model("donate_model");

        parent::__construct();
    }

    public function getApi()
    {
        $api = new ApiContext(
            new OAuthTokenCredential($this->config->item('paypal_userid'), $this->config->item('paypal_secretpass'))
        );

        $api->setConfig([
            'mode' => $this->config->item('paypal_mode'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => false,
            'log.FileName' => 'paypal_logs',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log'
        ]);

        return $api;
    }

    public function getSpecifyDonate($id)
    {
        $query = $this->db->select("*")
                                ->where("id", $id)
                                ->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0];
        }

        return false;
    }

    public function getDonations()
    {
        $query = $this->db->select("*")
                                ->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        }

        return false;
    }

    public function getStatus($id)
    {
        $query = $this->db->select("*")
                                ->where("payment_id", $id)
                                ->get("paypal_logs");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0]["status"];
        }

        return false;
    }

    public function setStatus($id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('payment_id', $id)->update('paypal_logs', $data);
    }

    public function getDonate($id)
    {
        $item = new Item();
        $payer = new Payer();
        $amount = new Amount();
        $details = new Details();
        $payment = new Payment();
        $itemList = new ItemList();
        $transaction = new Transaction();
        $redirectUrls = new RedirectUrls();

        $setTax = $this->getSpecifyDonate($id)['tax'];
        $setPrice = $this->getSpecifyDonate($id)['price'];
        $setTotal = ($setTax + $setPrice);

        //Payer
        $payer->setPaymentMethod('paypal');

        //item
        $item->setName('Donation')
        ->setCurrency($this->config->item('donation_currency'))
        ->setQuantity(1)
        ->setPrice($setPrice);

        //item list
        $itemList->setItems([$item]);

        //details
        $details->setShipping('0.00')
        ->setTax($setTax)
        ->setSubtotal($setPrice);

        $amount->setCurrency($this->config->item('donation_currency'))
        ->setTotal($setTotal)
        ->setDetails($details);

        //transaction
        $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription('Donation')
        ->setInvoiceNumber(uniqid());

        //payment
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions([$transaction]);

        //redirect urls
        $redirectUrls->setReturnUrl(base_url('/donate/checkPaypal/' . $id))
        ->setCancelUrl(base_url('/donate/canceled'));

        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions([$transaction]);

        try {
            $payment->create($this->getApi());

            $hash = md5($payment->getId());

            $date = new DateTime($payment->create_time);

            //prepare and execute
            $dataInsert = array(
                'user_id' => $this->user->getId(),
                'payment_id' => $payment->getId(),
                'hash' => $hash,
                'total' => $payment->transactions[0]->amount->total,
                'points' => $this->getSpecifyDonate($id)['points'],
                'create_time' => $date->getTimestamp(),
                'currency' => $this->config->item('donation_currency'),
                'status' => '0'
            );

            $this->db->insert('paypal_logs', $dataInsert);
        } catch (PayPalConnectionException $e) {
            echo $e->getData();
            die();
        }

        foreach ($payment->getLinks() as $key => $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
            }
        }

           header('Location: ' . $redirectUrl);
    }

    public function check($id)
    {
        $execute = new PaymentExecution();

        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];
        $payment = Payment::get($paymentId, $this->getApi());

        $execute->setPayerId($payerId);
        try {
            $result = $payment->execute($execute, $this->getApi());
        } catch (Exception $e) {
            die($e);
        }

        $this->completeTransaction($id, $_GET['paymentId']);
    }

    public function completeTransaction($donate, $id)
    {
        $qq = $this->getStatus($id);

        if ($qq == '1') {
            redirect(base_url('/donate'));
        } else {
            //transaction status
            $this->setStatus($id, "1");

            //update account
            $obtained_points = $this->getSpecifyDonate($donate)['points'];

            $this->donate_model->giveDp($this->user->getId(), $obtained_points);

            redirect(base_url('/donate/success'));
        }
    }
}

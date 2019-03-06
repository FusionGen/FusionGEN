<?php

class Postback_paypal extends MX_Controller 
{
	// User values
	private $custom;
	private $payment_status;
	private $payment_amount;
	private $payment_currency;
	private $txn_id;
	private $receiver_email;
	private $payer_email;
	private $pending_reason;

	// Config values
	private $config_paypal;

	// Debug
	private $debug = false;
	
	/**
	 * Initialize and prevent direct access
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->config('donate');
		$this->config_paypal = $this->config->item('donate_paypal');

		// Prevent direct access
		if(count($_POST) == 0)
		{
			if($this->debug)
			{
				$_POST['custom'] = "1";
				$_POST['payment_status'] = "Completed";
				$_POST['mc_gross'] = 100.0;
				$_POST['mc_currency'] = "USD";
				$_POST['txn_id'] = sha1(uniqid());
				$_POST['receiver_email'] = "YOUREMAIL@domain.com";
				$_POST['payer_email'] = "raxezdev@gmail.com";
			}
			else
			{
				die("No access");
			}
		}
	}
	
	/**
	 * Process the request
	 */
	public function index()
	{
		// Create our request string
		$req = '';
		if($this->config_paypal['sandbox'])
			$req = 'https://www.sandbox.paypal.com';
		else 
			$req = 'https://www.paypal.com';
		$req .= '/cgi-bin/webscr?';

		foreach($_POST AS $key => $value)
		{
			if( @get_magic_quotes_gpc() )
				$value = stripslashes($value);

			$values[] = "$key" . "=" . urlencode($value);
		}
		$req .= @implode("&", $values);

		// add paypal cmd variable
		$req .= "&cmd=_notify-validate";

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $req);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; FusionCMS; PayPal IPN Postback)");
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
		$res = curl_exec ($ch);
		curl_close($ch);

		// Gather the values we need
		$this->custom = $this->input->post('custom');
		$this->payment_status = $this->input->post('payment_status');
		$this->payment_amount = $this->input->post('mc_gross');
		$this->payment_currency = $this->input->post('mc_currency');
		$this->txn_id = $this->input->post('txn_id');
		$this->receiver_email = $this->input->post('receiver_email');
		$this->payer_email = $this->input->post('payer_email');
		
		/*
		 * REASON LEGENDA:
		 * multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.
		 * order: You set the payment action to Order and have not yet captured funds.
		 * paymentreview: The payment is pending while it is being reviewed by PayPal for risk.
		 * unilateral: The payment is pending because it was made to an email address that is not yet registered or confirmed.
		 * upgrade: The payment is pending because it was made via credit card and you must upgrade your account to Business or Premier status in order to receive the funds. upgrade can also mean that you have reached the monthly limit for transactions on your account.
		 * verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.
		 * other: The payment is pending for a reason other than those listed above. For more information, contact PayPal Customer Service.
		 */
		$this->pending_reason = $this->input->post('pending_reason');

		//Standard we didn't validated it.
		$validated = 0;
		$error_count = 0;
		$error = "";

		if(!$res)
		{
			//HTTP ERROR, Could not connect to paypal.
			$error = 'Http error happened, could not connect to paypal.';
		}
		else
		{
			if($this->debug)
			{
				$res = "DEBUG ONLY RESPONSE THAT MAKES THIS PAYMENT BECOME VERIFIED";
			}

			if(stristr($res, "VERIFIED")) 
			{
				// Make sure the currency is correct
				if($this->payment_currency != $this->config->item('donation_currency'))
				{
					$error .= "Invalid currency (set to ".$this->payment_currency.")<br />";
					$error_count++;
				}

				// Make sure the receiver email is correct
				if($this->receiver_email != $this->config_paypal['email'])
				{
					$error .= "Invalid receiver email (set to ".$this->receiver_email.")<br />";
					$error_count++;
				}

				// Make sure the payment has not already been processed
				if($this->transactionExists($this->txn_id) && $this->transactionIsAlreadyValidated($this->txn_id))
				{
					$error .= "Payment has already been processed<br />";
					$error_count++;
				}

				// Make sure payment status is completed
				if($this->payment_status != "Completed")
				{
					$error .= "Payment status is not completed (".$this->payment_status.")<br />";
					$error_count++;
				}
				
				//Add pending reasons
				if($this->pending_reason == "unilateral")
				{
					$error .= "Pending_reason: unilateral<br />";
					$error .= "The payment is pending because it was made to an email address that is not yet registered or confirmed.<br />";
					$error_count += 2;
				}
				
				//If no errors where posted, process payment and add points.
				if($error_count == 0)
				{
					// Update the account with the given money multiplied by the money multiplier
					$dpReward = $this->getDpAmount();
						
					// Update account with donation points
					$this->db->query("UPDATE `account_data` SET `dp` = `dp` + ? WHERE `id` = ?", array($dpReward, $this->custom));

					// Update the transaction log and set validated to 1
					$validated = 1;

					$this->updateMonthlyIncome(); 
				}
			}
			elseif(stristr($res, "INVALID"))
			{
				$error .= "PayPal validation failed: invalid transaction<br />";
				$error_count++;
			}
			else
			{
				$error .= "Unknown problem<br />";
			}
			
			//insert the logs
			// Gather our database log datas, insert here already because of validation.
			$data = array(
				"payment_status" => $this->payment_status,
				"payment_amount" => $this->payment_amount,
				"payment_currency" => $this->payment_currency,
				"txn_id" => $this->txn_id,
				"receiver_email" => $this->receiver_email,
				"payer_email" => $this->payer_email,
				"user_id" => $this->custom,
				"validated" => $validated,
				"timestamp" => time(),
				"error" => (isset($error)) ? $error : "",
				"pending_reason" => $this->pending_reason
			);

			$this->plugins->onDonationPostback($data['user_id'], $validated, $data['payment_amount'], $this->getDpAmount());

			$this->db->insert("paypal_logs", $data);

			die();
		}
	}

	/**
	 * Get the amount of DP
	 */
	private function getDpAmount()
	{
		$config = $this->config->item('donate_paypal');

		$points = 0;
		
		foreach($config['values'] as $price => $reward)
		{
			if($price == round($this->payment_amount))
			{
				$points = $reward;
			}
		}

		return $points;
	}

	/**
	 * Check if a transaction exists
	 * @param String $txn_id
	 * @return Boolean
	 */
	private function transactionExists($txn_id)
	{
		$query = $this->db->query("SELECT COUNT(*) as `total` FROM paypal_logs WHERE txn_id=?", array($txn_id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			if($row[0]['total'] > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check if a transaction is already validated
	 * @param String $txn_id
	 * @return Boolean
	 */
	private function transactionIsAlreadyValidated($txn_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM paypal_logs WHERE validated = 1 AND txn_id=?", array($txn_id));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return ($row[0]['total'] > 0);
		}

		return false;
	}

	private function updateMonthlyIncome()
	{
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM monthly_income WHERE month=?", array(date("Y-m")));

		$row = $query->result_array();

		if($row[0]['total'])
		{
			$this->db->query("UPDATE monthly_income SET amount = amount + ".floor($this->payment_amount)." WHERE month=?", array(date("Y-m")));
		}
		else
		{
			$this->db->query("INSERT INTO monthly_income(month, amount) VALUES(?, ?)", array(date("Y-m"), floor($this->payment_amount)));
		}
	}
}

<?php

class Postback_paygol extends MX_Controller 
{
	private $debug = false;
	private $fields = array();

	public function __construct()
	{
		parent::__construct();
		
		$this->load->config('donate');

		$serverArr = array(
			'109.70.3.48', 
			'109.70.3.146', 
			'109.70.3.58'
		);

		// check that the request comes from PayGol server
		if(!in_array($_SERVER['REMOTE_ADDR'], $serverArr) && !$this->debug) 
		{
			header("HTTP/1.0 403 Forbidden");

			die("Error: invalid IP");
		}

		if($this->debug)
		{
			$this->fields['message_id'] = uniqid();
			$this->fields['service_id'] = "12345";
			$this->fields['shortcode'] = "12345";
			$this->fields['keyword'] = "DEBUG";
			$this->fields['message'] = "12345";
			$this->fields['sender'] = "123456789";
			$this->fields['operator'] = "raxezdev";
			$this->fields['country'] = "SE";
			$this->fields['custom'] = "1";
			$this->fields['points'] = "";
			$this->fields['price'] = "300";
			$this->fields['currency'] = "SEK";
		}
	}
	
	public function index()
	{
		if(!$this->debug)
		{
			$this->fields = array(
				"message_id" => "",
				"service_id" => "",
				"shortcode" => "",
				"keyword" => "",
				"message" => "",
				"sender" => "",
				"operator" => "",
				"country" => "",
				"custom" => "",
				"points" => "",
				"price" => "",
				"currency" => ""
			);

			foreach($this->fields as $field => $value)
			{
				$this->fields[$field] = $this->input->get($field);
			}
		}

		if(strtoupper($this->fields['currency']) != strtoupper($this->config->item('donation_currency')))
		{
			// We need to convert the currency
			$this->fields['converted_price'] = $this->convertCurrency($this->fields['price'], $this->fields['currency']);
		}
		else
		{
			$this->fields['converted_price'] = $this->fields['price'];
		}

		$this->fields['points'] = $this->getDpAmount();

		$this->db->query("UPDATE `account_data` SET `dp` = `dp` + ? WHERE `id` = ?",array($this->fields['points'], $this->fields['custom']));

		$this->fields['timestamp'] = time();

		$this->plugins->onDonationPostback($this->fields['custom'], true, $this->fields['converted_price'], $this->fields['points']);

		$this->db->insert("paygol_logs", $this->fields);
		
		$this->updateMonthlyIncome($this->fields['converted_price']);

		die('success');
	}

	/**
	 * Get the amount of DP
	 */
	private function getDpAmount()
	{
		$config = $this->config->item('donate_paygol');

		$points = 0;
		
		// Find exact values first
		foreach($config['values'] as $price => $reward)
		{
			if($price == $this->fields['converted_price'])
			{
				$points = $reward;
			}
		}

		// Give it anything try, less accurate
		if($points == 0)
		{
			$closestDifference = false;
			$closestReward = 0;

			foreach($config['values'] as $price => $reward)
			{
				$difference = abs($price - $this->fields['converted_price']);
				
				if(!$closestDifference || $difference < $closestDifference)
				{
					$closestDifference = $difference;
					$closestReward = $reward;
				}
			}

			$points = $closestReward;
		}

		return $points;
	}

	private function convertCurrency($price, $currency)
	{
		$response = file_get_contents("http://www.google.com/ig/calculator?hl=en&q=".$price.$currency."%3D%3F".$this->config->item('donation_currency'));

		$response = explode(":", $response);
		$response[2] = preg_replace("/ [A-Za-z]+.*$/", "", $response[2]);
		$response[2] = substr($response[2], 2);
		
		return (float)$response[2];
	}

	private function updateMonthlyIncome($price)
	{
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM monthly_income WHERE month=?", array(date("Y-m")));

		$row = $query->result_array();

		if($row[0]['total'])
		{
			$this->db->query("UPDATE monthly_income SET amount = amount + ".round($price)." WHERE month=?", array(date("Y-m")));
		}
		else
		{
			$this->db->query("INSERT INTO monthly_income(month, amount) VALUES(?, ?)", array(date("Y-m"), round($price)));
		}
	}
}

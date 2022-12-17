<?php

class Admin extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('donate_model');
        $this->load->config('donate');

        parent::__construct();

        requirePermission("viewAdmin");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Donation log");

        //get the config items.
        $paypal_enabled = $this->config->item('donate_paypal');

        $paypal = $this->donate_model->getDonationLog('paypal');

        if ($paypal) {
            foreach ($paypal as $k => $v) {
                $paypal[$k]["nickname"] = $this->user->getUsername($v['user_id']);
            }
        }

        $monthlyIncome = $this->donate_model->getMonthlyIncome();

        // Prepare my data
        $data = array(
            'paypal_enabled' => $paypal_enabled['use'],
            'paypal_logs' => $paypal,
            'url' => $this->template->page_url,
            'currency' => $this->config->item('donation_currency'),
            'monthly_income_stack' => $this->arrayFormat($monthlyIncome),
            'top' => $this->getHighestValue($monthlyIncome),
            'first_date' => $this->getFirstDate($monthlyIncome),
            'last_date' => $this->getLastDate($monthlyIncome)
        );

        // Load my view
        $output = $this->template->loadPage("admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Donation log', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/donate/js/admin.js");
    }

    private function getHighestValue($array)
    {
        if ($array) {
            $highest = 0;

            foreach ($array as $value) {
                if ($value['amount'] > $highest) {
                    $highest = $value['amount'];
                }
            }

            return $highest;
        } else {
            return false;
        }
    }

    private function arrayFormat($array)
    {
        if ($array) {
            $output = "";
            $first = true;

            foreach ($array as $month) {
                if ($first) {
                    $first = false;
                    $output .= $month['amount'];
                } else {
                    $output .= "," . $month['amount'];
                }
            }

            return $output;
        } else {
            return false;
        }
    }

    private function getLastDate($array)
    {
        if ($array) {
            return preg_replace("/-/", " / ", $array[count($array) - 1]['month']);
        } else {
            return false;
        }
    }

    private function getFirstDate($array)
    {
        if ($array) {
            return preg_replace("/-/", " / ", $array[0]['month']);
        } else {
            return false;
        }
    }

    public function search($type = false)
    {
        $string = $this->input->post('string');

        if (!$string || !$type || !in_array($type, array('paypal'))) {
            die();
        } else {
            if ($type == "paypal") {
                if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
                    // Email
                    $results = $this->donate_model->findByEmail($type, $string);
                } elseif (preg_match("/^[A-Z0-9]{17}$/", $string)) {
                    // TXN-ID
                    $results = $this->donate_model->findByTxn($type, $string);
                } elseif (preg_match("/^[a-zA-Z0-9]*$/", $string) && strlen($string) > 3 && strlen($string) < 15) {
                    // Username
                    $user_id = $this->user->getId($string);

                    if (!$user_id) {
                        die("<span>Unknown account</span>");
                    }

                    $results = $this->donate_model->findById($type, $user_id);
                } else {
                    $results = $this->donate_model->getDonationLog($type);
                }

                if (!$results) {
                    die("<span>No matches</span>");
                }
            }

            foreach ($results as $k => $v) {
                if ($type == "paypal") {
                    $results[$k]["nickname"] = $this->user->getUsername($v['user_id']);
                } else {
                    $results[$k]["nickname"] = $this->user->getUsername($v['custom']);
                }
            }

            $data = array(
                'url' => $this->template->page_url,
                'results' => $results,
                'type' => $type
            );

            $output = $this->template->loadPage("admin_list.tpl", $data);

            die($output);
        }
    }

    public function give($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $log = $this->donate_model->getPayPalLog($id);

        if (!$log) {
            die();
        }

        $dp = $log["points"];

        $this->donate_model->giveDp($log['user_id'], $dp);

        $data["status"] = 1;

        $this->donate_model->updateMonthlyIncome($log['total']);
        $this->donate_model->updatePayPal($id, $data);

        // Add log
        $this->logger->createLog('Manually completed transaction', $id);
    }

    /**
     * Get the amount of DP
     *
     * @param Int $payment_amount
     */
    private function getDpAmount($payment_amount)
    {
        $config = $this->config->item('donate_paypal');

        $points = 0;

        foreach ($config['values'] as $price => $reward) {
            if ($price == round($payment_amount)) {
                $points = $reward;
            }
        }

        return $points;
    }
}

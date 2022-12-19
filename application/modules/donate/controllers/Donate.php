<?php

class Donate extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        //Make sure that we are logged in
        $this->user->userArea();

        $this->load->config('donate');
        $this->load->model('donate_model');
        $this->load->model('paypal_model');
    }

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("donate_title", "donate"));

        $donate_paypal = $this->config->item('donate_paypal');

        $user_id = $this->user->getId();

        $paypal = array(
            "values" => $this->paypal_model->getDonations()
        );

        if ($this->input->post()) {
            if ($this->input->post("donation_type") == "paypal") {
                $this->paypal_model->getDonate($this->input->post("data_id"));
            }
        }

        $data = array(
            "paypal" => $paypal,
            "use_paypal" => $this->config->item("use_paypal"),
            "user_id" => $user_id,
            "server_name" => $this->config->item('server_name'),
            "currency" => $this->config->item('donation_currency'),
            "currency_sign" => $this->config->item('donation_currency_sign'),
            "multiplier" => $this->config->item('donation_multiplier'),
            "url" => pageURL
        );

        $output = $this->template->loadPage("donate.tpl", $data);

        $this->template->box("<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "ucp\"'>" . lang("ucp") . "</span> &rarr; " . lang("donate_panel", "donate"), $output, true, "modules/donate/css/donate.css", "modules/donate/js/donate.js");
    }

    public function canceled()
    {
        //$this->session->set_flashdata('donation_status','canceled');
        redirect(base_url('/donate'));
    }

    public function checkPaypal($id)
    {
        $this->paypal_model->check($id);
    }

    public function success()
    {
        $this->user->getUserData();

        $page = $this->template->loadPage("success.tpl", array('url' => $this->template->page_url));

        $this->template->box(lang("donate_thanks", "donate"), $page, true);
    }
}

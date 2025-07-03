<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getCaptcha extends MX_Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->load->library('captcha');

        $this->captcha->generate();
        $this->captcha->output();
        exit; // and exit
    }
}

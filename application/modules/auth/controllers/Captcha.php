<?php

defined('BASEPATH') || die('Silence is golden.');

class Captcha extends MX_Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->load->helper('captcha');


        $vals = array(
             'img_path'   => FCPATH . '/uploads/captcha/',
             'img_url'    => pageURL . '/uploads/captcha/',
             'font_size'  => 16,

             'colors'     => array(
             'background' => array(0, 0, 0),
             'border'     => array(255, 255, 255),
             'text'       => array(255, 255, 255),
             'grid'       => array(255, 40, 40)
             )
         );

        $cap = create_captcha($vals);
        die(print_r($cap));
    }
}

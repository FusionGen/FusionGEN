<?php

/**
 *
 * Enable captcha for site
 *
 */
$config["use_captcha"] = true;

/**
 *
 * What type of captcha?
 *
 * 'recaptcha' = Google Recaptcha v2 | NOT WORKING ATM
 * 'inbuilt'   = FusionGen inbuilt captcha system
 *
 */
$config["captcha_type"] = 'inbuilt';

/**
 *
 * After how many tries should a captcha pop up?
 *
 */
$config["captcha_attemps"] = 3;

/**
 *
 * The site key
 * get site key @ www.google.com/recaptcha/admin
 *
 */
$config["recaptcha_sitekey"] = "";

/**
 *
 * The secret key
 * get secret key @ www.google.com/recaptcha/admin
 *
 */
$config["recaptcha_secretkey"] = "";

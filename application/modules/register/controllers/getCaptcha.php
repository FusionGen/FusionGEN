<?php

require('../../../libraries/captcha.php');

$captcha = new Captcha();

$captcha->generate();
$captcha->output(70, 25);
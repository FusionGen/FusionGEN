<?php

/**
 * Send a mail
 * @param String $receiver
 * @param String $sender
 * @param String $subject
 * @param String $message
 */
function sendMail($receiver, $sender, $subject, $message)
{
	static $CI;

	if(!$CI)
	{
		$CI = &get_instance();
	}

	// Make sure the website has SMTP available
	if(!$CI->config->item('has_smtp'))
	{
		return false;
	}

	$CI->load->config('smtp');

	// Pass the custom SMTP settings if any
	if($CI->config->item('use_own_smtp_settings'))
	{
		$config['protocol'] = "smtp";
		$config['smtp_host'] = $CI->config->item('smtp_host');
		$config['smtp_user'] = $CI->config->item('smtp_user');
		$config['smtp_pass'] = $CI->config->item('smtp_pass');
		$config['smtp_port'] = $CI->config->item('smtp_port');
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
	}

	// Configuration
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';

	$CI->load->library('email', $config);

	// Set email data
	$CI->email->from($sender, $CI->config->item('server_name'));
	$CI->email->to($receiver);
	$CI->email->subject($subject);
	$CI->email->message($message);

	// Send the email
	$CI->email->send();

	if($CI->config->item('mail_debug'))
	{
		// Display the debugger message
		die($CI->email->print_debugger());
	}
}
<?php

/**
 * Fixes the client IP if cloudflare is enabled.
 * 
 * @package FusionCMS
 * @author Maxi Arnicke
 * @link http://fusion-hub.com
 */

require_once(APPPATH.'hooks/cloudflare/ip_in_range.php');

function fix_cf_ip()
{
	if ( ! isset($_SERVER['HTTP_CF_CONNECTING_IP']))
		return;
	
	if (strpos($_SERVER['REMOTE_ADDR'], ':') === FALSE)
	{
		$cf_ip_ranges = array("204.93.240.0/24","204.93.177.0/24","199.27.128.0/21","173.245.48.0/20","103.21.244.0/22","103.22.200.0/22","103.31.4.0/22","141.101.64.0/18","108.162.192.0/18","190.93.240.0/20","188.114.96.0/20","197.234.240.0/22","198.41.128.0/17","162.158.0.0/15");
        
		foreach ($cf_ip_ranges as $range) {
			if (ipv4_in_range($_SERVER['REMOTE_ADDR'], $range)) {
        		$_SERVER['REMOTE_ADDR_CF'] = $_SERVER['REMOTE_ADDR'];
				$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
				break;
			}
		}
	}
	else
	{
		$cf_ip_ranges = array("2400:cb00::/32","2606:4700::/32","2803:f800::/32","2405:b500::/32","2405:8100::/32");
		$ipv6 = get_ipv6_full($_SERVER['REMOTE_ADDR']);
		
		foreach ($cf_ip_ranges as $range) {
			if (ipv6_in_range($ipv6, $range)) {
        		$_SERVER['REMOTE_ADDR_CF'] = $_SERVER['REMOTE_ADDR'];
				$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
				break;
			}
		}
	}
}

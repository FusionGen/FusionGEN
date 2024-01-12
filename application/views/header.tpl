<!DOCTYPE html>

<!--
This website is powered by FusionGEN

https://github.com/FusionGen/FusionGen

Current FusionGEN Version: {$CI->config->item('FusionGENVersion')}
-->

<html>
	<head>
		<title>{$title}</title>
		
		{if $extra_css}<link rel="stylesheet" href="{$path}{$extra_css}">{/if}
		{*	{if !is_array($extra_css)}
				<link rel="stylesheet" href="{$path}{$extra_css}">
			{else}
				{strip}
					{foreach from=$extra_css item=css}
						<link rel="stylesheet" href="{$path}{$css}">
					 {/foreach}
				{/strip}
			{/if}
		{/if} *}
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">

		<link rel="icon" type="image/x-icon" href="{$favicon}">
		
		<!-- Search engine related -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="{$description}">
		<meta name="keywords" content="{$keywords}">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
		
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- Load scripts -->
		<script src="{$url}application/js/html5shiv.js"></script>
		<script src="{$url}application/js/jquery.min.js"></script>
		<script>var isIE = false;</script>
		<script src="{$path}js/router.js"></script>
		<script src="{$path}js/require.js"></script>
		<script>

			if(!window.console)
			{
				var console = {
				
					log: function()
					{
						// Prevent stupid browsers from doing stupid things
						// *cough* Internet Explorer *cough*
					}
				};
			}

			function getCookie(c_name)
			{
				var i, x, y, ARRcookies = document.cookie.split(";");

				for(i = 0; i < ARRcookies.length;i++)
				{
					x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
					y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
					x = x.replace(/^\s+|\s+$/g,"");

					if(x == c_name)
					{
						return unescape(y);
					}
				}
			}

			function setCookie(c_name,value,exdays)
			{
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value = escape(value) + ((exdays == null) ? "" : "; expires="+exdate.toUTCString());
				document.cookie = c_name + "=" + c_value;
			}

			var Config = {
				URL: "{$url}",			
				image_path: "{$image_path}",
				CSRF: getCookie('csrf_cookie_name'),
				language: "{$activeLanguage}",

				UseFusionTooltip: {if $use_fcms_tooltip}1{else}0{/if},

				Slider: {
					interval: {$slider_interval},
					effect: "{$slider_style}",
					id: "{$slider_id}"
				},

				voteReminder: {if $vote_reminder}1{else}0{/if},

				Theme: {
					next: "{$slider.next}",
					previous: "{$slider.previous}"
				}
			};

			var scripts = [
				"{$path}js/ui.js",
				"{$path}js/fusioneditor.js",
				"{$path}js/flux.min.js",
				"{$path}js/jquery.placeholder.min.js",
				"{$path}js/jquery.sort.js",
				"{$path}js/jquery.transit.min.js",
				"{$path}js/language.js",

				{if $extra_js},"{$path}{$extra_js}"{/if}
				{*	{if !is_array($extra_js)}
						,"{$path}{$extra_js}"
					{else}
						{strip}
							{foreach from=$extra_js item=js}
								,"{$path}{$js}"
							 {/foreach}
						{/strip}
					{/if}
				{/if} *}
			];

			if(typeof JSON == "undefined")
			{
				scripts.push("{$path}js/json2.js");
			}

			require(scripts, function()
			{
				$(document).ready(function()
				{
					{if $client_language}
						Language.set("{addslashes($client_language)}");
					{/if}

					UI.initialize();

					{if $extra_css}Router.loadedCSS.push("{$extra_css}");{/if}
					{*	{if !is_array($extra_css)}
							Router.loadedCSS.push("{$extra_css}");
						{else}
							{strip}
								{foreach from=$extra_css item=css}
									Router.loadedCSS.push("{$css}");
								 {/foreach}
							{/strip}
						{/if}
					{/if} *}

					{if $extra_js}Router.loadedJS.push("{$extra_js}");{/if}
					{*	{if !is_array($extra_js)}
							Router.loadedJS.push("{$extra_js}");
						{else}
							{strip}
								{foreach from=$extra_js item=js}
									Router.loadedJS.push("{$js}");
								 {/foreach}
							{/strip}
						{/if}
					{/if} *}
				});
			});
		</script>

		{if $analytics}
		<script>
		// Google Analytics
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '{$analytics}']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

		</script>
		{/if}

	</head>
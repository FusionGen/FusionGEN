<!DOCTYPE html>

<!--

 This website is powered by
  ______         _              _____ __  __  _____ 
 |  ____|       (_)            / ____|  \/  |/ ____|
 | |__ _   _ ___ _  ___  _ __ | |    | \  / | (___  
 |  __| | | / __| |/ _ \| '_ \| |    | |\/| |\___ \ 
 | |  | |_| \__ \ | (_) | | | | |____| |  | |____) |
 |_|   \__,_|___/_|\___/|_| |_|\_____|_|  |_|_____/ 

 www.fusion-hub.com

-->

<html>
	<head>
		<title>{$title}</title>
		
		<link rel="stylesheet" href="{$path}css/default.css" type="text/css" />
		<link rel="stylesheet" href="{$style_path}cms.css" type="text/css" />
		<link rel="stylesheet" href="{$style_path}main.css" type="text/css" />
		{if $extra_css}<link rel="stylesheet" href="{$path}{$extra_css}" type="text/css" />{/if}
		
		<link rel="shortcut icon" href="{$favicon}" />
		
		<!-- Search engine related -->
		<meta name="description" content="{$description}" />
		<meta name="keywords" content="{$keywords}" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
		<!-- Load scripts -->
		<script src="{if $cdn}//html5shiv.googlecode.com/svn/trunk/html5.js{else}{$path}js/html5shiv.js{/if}"></script>
		<script type="text/javascript" src="{if $cdn}https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js{else}{$path}js/jquery.min.js{/if}"></script>
		<script type="text/javascript">var isIE = false;</script>
		<!--[if IE]><script type="text/javascript">isIE = true;</script><![endif]-->
		<script type="text/javascript" src="{$path}js/router.js"></script>
		<script type="text/javascript" src="{$path}js/require.js"></script>
		<script type="text/javascript">

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

					{if $extra_css}
						Router.loadedCSS.push("{$extra_css}");
					{/if}

					{if $extra_js}
						Router.loadedJS.push("{$extra_js}");
					{/if}
				});
			});
		</script>

		{if $analytics}
		<script type="text/javascript">
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
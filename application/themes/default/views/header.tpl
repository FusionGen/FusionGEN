<!DOCTYPE html>

<!--
This website is powered by FusionGEN

https://github.com/FusionGen/FusionGen

Current FusionGEN Version: {$CI->config->item('FusionGENVersion')}
-->

<html lang="zxx">
	<head>
		<title>{$title}</title>
		<meta charset="UTF-8">
		<meta name="description" content="{$description}">
		<meta name="keywords" content="{$keywords}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta property="og:title" content="{$title}">
		<meta property="og:type" content="website">
		<meta property="og:image" content="{$url}application/images/misc/preview-thumbnail.png">
		<meta property="og:url" content="{$url}">
		<meta property="og:description" content="{$description}">
		<meta property="og:site_name" content="{$serverName}">

		<link rel="icon" type="image/x-icon" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/images/favicon.ico">

		<!-- Header CSS.Start -->
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Bootstrap/5.2.3/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Sweetalert2/css/sweetalert2.min.css">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/AnimateCSS/4.1.1/animate.min.css">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/css/owl.carousel.min.css">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/css/owl.theme.default.min.css">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/MagnificPopup/css/magnific-popup.css">
		<link rel="stylesheet" href="{$url}application/css/default.css">
		<link rel="stylesheet" href="{$url}application/css/tooltip.css">
		<link rel="stylesheet" href="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/css/style.css">

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

		<!-- Header CSS.End -->

		<!-- Header JS.Start -->
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/jquery-3.7.1.min.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{else}{$url}{/if}application/js/jquery.sort.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js" integrity="sha512-6BTOlkauINO65nLhXhthZMtepgJSghyimIalb+crKRPhvhmsCdnIuGcVbR5/aQY2A+260iC1OPy1oCdB6pSSwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Sweetalert2/js/sweetalert2.all.min.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/Marquee/jquery.marquee.min.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/OwlCarousel2/js/owl.carousel.min.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}vendor/MagnificPopup/js/jquery.magnific-popup.min.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/main.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/cookie.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{$theme_path}{else}{$full_theme_path}{/if}assets/js/slider.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{else}{$url}{/if}application/js/ui.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{else}{$url}{/if}application/js/language.js"></script>
		<script src="{if $cdn_link}{$cdn_link}{else}{$url}{/if}application/js/tooltip.js"></script>
		<!-- Load wowhead tooltip -->
		{if !$use_fcms_tooltip}
		<script>const whTooltips = { colorLinks: false, iconizeLinks: false, renameLinks: false };</script>
		<script src="https://wow.zamimg.com/js/tooltips.js"></script>
		{/if}

		{if $extra_js}<script src="{$path}{$extra_js}"></script>{/if}
		{*	{if !is_array($extra_js)}
				<script src="{$path}{$extra_js}"></script>
			{else}
				{strip}
					{foreach from=$extra_js item=js}
						<script src="{$path}{$js}"></script>
					 {/foreach}
				{/strip}
			{/if}
		{/if} *}

		<!-- Header JS.End -->
		<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.11/datatables.min.css">

		<script src="https://cdn.datatables.net/v/bs5/dt-1.13.11/datatables.min.js"></script>

		<script>
			var isIE = isIE();
			var Config = {
				URL: "{$url}",
				image_path: "{$image_path}",
				CSRF: getCookie('csrf_cookie_name'),
				language: "{$activeLanguage}",
				UseFusionTooltip: {if $use_fcms_tooltip}1{else}0{/if},

				Slider: {
					interval: {$slider_interval},
					effect: {if $slider_style}{$slider_style}{else}""{/if}

				}
			};

			$(document).ready(function() {
				{if $client_language}Language.set("{addslashes($client_language)}");{/if}
				Tooltip.initialize();
			});
			UI.initialize();

			{if $analytics}
				// Google Analytics
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '{$analytics}']);
				_gaq.push(['_trackPageview']);

				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			{/if}
		</script>
	</head>
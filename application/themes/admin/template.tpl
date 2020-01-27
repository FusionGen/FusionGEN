<!DOCTYPE html>
<html>
	<head>
		<title>{if $title}{$title}{/if}FusionGEN</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<link rel="shortcut icon" href="{$url}application/themes/admin/images/favicon.png" />
		<link rel="stylesheet" href="{$url}application/themes/admin/css/main.css" type="text/css" />
		{if $extra_css}<link rel="stylesheet" href="{$url}application/{$extra_css}" type="text/css" />{/if}

		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.js"></script>
		<script type="text/javascript" src="{if $cdn}https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js{else}{$url}application/js/jquery.min.js{/if}"></script>

		<script type="text/javascript">
		
			if(!window.console)
			{
				var console = {
				
					log: function()
					{
						// Prevent stupid browsers from doing stupid things
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

			var Config = {
				URL: "{$url}",
				CSRF: getCookie('csrf_cookie_name'),
				isACP: true,
				defaultLanguage: "{$defaultLanguage}",
				languages: [ {foreach from=$languages item=language}"{$language}",{/foreach} ]
			};
		</script>

		<script src="{$url}application/themes/admin/js/router.js" type="text/javascript"></script>
		<script src="{$url}application/js/require.js" type="text/javascript" ></script>
		
		<script type="text/javascript">

			var scripts = [
				"{$url}application/js/jquery.placeholder.min.js",
				"{$url}application/js/jquery.transit.min.js",
				"{$url}application/js/ui.js",
				"{$url}application/js/fusioneditor.js"
				{if $extra_js},"{$url}application/{$extra_js}"{/if}
			];

			require(scripts, function()
			{
				$(document).ready(function()
				{
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

		<!--[if IE]>
			<style type="text/css">
			#main .right h2 img {
				position:relative;
			}
			</style>
		<![endif]-->

		<!--[if LTE IE 7]>
			<style type="text/css">
			#main .right .statistics span {
				width:320px;
			}
			</style>
		<![endif]-->
	</head>

	<body>
		<div id="popup_bg"></div>

		<!-- confirm box -->
		<div id="confirm" class="popup">
			<h1 class="popup_question" id="confirm_question"></h1>

			<div class="popup_links">
				<a href="javascript:void(0)" class="popup_button" id="confirm_button"></a>
				<a href="javascript:void(0)" class="popup_hide" id="confirm_hide" onClick="UI.hidePopup()">
					Cancel
				</a>
				<div style="clear:both;"></div>
			</div>
		</div>

		<!-- alert box -->
		<div id="alert" class="popup">
			<h1 class="popup_message" id="alert_message"></h1>

			<div class="popup_links">
				<a href="javascript:void(0)" class="popup_button" id="alert_button">Okay</a>
				<div style="clear:both;"></div>
			</div>
		</div>

		<!-- Top bar -->
		<header>
		<center>
			<div class="center_1020">
				<a href="{$url}admin/" class="logo"></a>

				<!-- Top menu -->
				<aside class="right">
					<nav>
						<a target="_blank" href="{$url}ucp" data-hasevent="1">
							Go back
						</a>

						{if hasPermission("editSystemSettings", "admin")}
							<a href="{$url}admin/settings" {if $current_page == "admin/settings"}class="active"{/if}>
								Settings
							</a>
						{/if}

						<a href="{$url}admin/" {if $current_page == "admin/"}class="active"{/if}>
							Dashboard
						</a>
					</nav>
				</aside>
			</div>
		</center>
		</header>

		<!-- Main content -->
		<section id="wrapper">
			<div id="top_spacer"></div>
			<div class="center_1020" id="main">

				<!-- Main Left column -->
				<aside class="left">
					<nav>
						{foreach from=$menu item=group key=text}
							{if count($group.links)}
								<a>{$text}</a>

								<section class="sub">
									{foreach from=$group.links item=link}
										<a href="{$url}{$link.module}/{$link.controller}" {if isset($link.active)}class="active"{/if}>{$link.text}</a>
									{/foreach}
								</section>
							{/if}
						{/foreach}
					</nav>
					<div class="spacer"></div>
				</aside>

				<!-- Main right column -->
				<aside class="right">
					{$page}
				</aside>

				<div class="clear"></div>
			</div>
		</section>

		<!-- Footer -->
		<footer>
			<div class="center_1020">
				<div class="Footer_Content">
				<aside id="logo"><a href="#" class="logo"></a></aside>
				<aside id="discord">
					<h1>Join our Discord Server</h1>
					<div id="discord_icon"></div>
					<a href="https://discord.gg/vRnr6WJ" target="_blank">FusionGEN</a>
				</aside>
				<aside id="html5">
					<a href="http://www.w3.org/html/logo/" data-tip="This website makes use of the next generation of web technologies">
						<img src="{$url}application/themes/admin/images/html5.png">
					</a>
				</aside>
				</div>
				<div class="clear"></div>
			</div>
		</footer>
	</body>
</html>
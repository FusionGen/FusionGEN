<!DOCTYPE html>
<html>
	<head>
		<title>Log in - FusionCMS</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<link rel="shortcut icon" href="{$url}application/themes/admin/images/favicon.png" />
		<link rel="stylesheet" href="{$url}application/themes/admin/css/login.css" type="text/css" />

		<script src="{if $cdn}//html5shiv.googlecode.com/svn/trunk/html5.js{else}{$url}application/js/html5shiv.js{/if}"></script>
		<script type="text/javascript" src="{if $cdn}https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js{else}{$url}application/js/jquery.min.js{/if}"></script>

		<script type="text/javascript">
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
			};
		</script>

		<script src="{$url}application/js/require.js" type="text/javascript" ></script>
		<script type="text/javascript">

			var scripts = [
				"{$url}application/js/jquery.placeholder.min.js",
				"{$url}application/js/jquery.transit.min.js",
				"{$url}application/themes/admin/js/login.js"
			];

			require(scripts, function()
			{
				$('input[placeholder], textarea[placeholder]').placeholder();
			});
		</script>
	</head>

	<body>
		<div id="wrap">
			<div id="fixer">
				<!-- Top bar -->
				<header>
					<div class="center_1020">
						<a href="#" class="logo"></a>

						<!-- Top menu -->
						<aside class="right">
							<nav>
								<a href="#" class="active">
									<div class="icon logout"></div>
									Log in
								</a>
							</nav>

							<div class="welcome">
								Welcome, <b>{if $isOnline}{ucfirst($username)}{else}stranger{/if}</b>
							</div>
						</aside>
					</div>
				</header>

				<div id="content">
					<h1>Administration</h1>

					<form onSubmit="Login.send(this); return false">
						<input type="text" placeholder="Username" {if $isOnline}disabled value="{$username}"{/if} id="username"/>
						<img src="{$url}application/themes/admin/images/icons/user.png" /><input type="password" placeholder="Password" {if $isOnline}disabled value="Password"{/if} id="password"><img src="{$url}application/themes/admin/images/icons/lock.png" /><input type="password" placeholder="Security code" id="security_code" />
						<img src="{$url}application/themes/admin/images/icons/star.png" />
						<input type="submit" value="Log in" />
					</form>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<footer>
			<div class="center_1020">
				<div class="divider2"></div>
				<aside id="logo"><a href="#" class="logo"></a></aside>
				<div class="divider"></div>
				<aside id="links">
					<a href="http://fusion-hub.com/" target="_blank">FusionHub</a>
					<a href="http://fusion-hub.com/modules" target="_blank">Modules</a>
					<a href="http://fusion-hub.com/themes" target="_blank">Themes</a>
					<a href="http://fusion-hub.com/support" target="_blank">Support</a>
				</aside>
				<div class="divider"></div>
				<aside id="twitter">
					<h1>Follow us on Twitter!</h1>
					<div id="twitter_icon"></div>
					<a href="http://twitter.com/FusionHub" target="_blank">@FusionHub</a>
				</aside>
				<div class="divider"></div>
				<aside id="html5">
					<a href="http://www.w3.org/html/logo/" data-tip="This website makes use of the next generation of web technologies">
						<img src="{$url}application/themes/admin/images/html5.png">
					</a>
				</aside>
				<div class="divider"></div>
				<div class="clear"></div>
			</div>
		</footer>
	</body>
</html>
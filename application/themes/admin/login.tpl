<!DOCTYPE html>
<html>
	<head>
		<title>Admin Control Panel | FusionGEN</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<link rel="shortcut icon" href="{$url}application/themes/admin/images/favicon.png" />
		<link rel="stylesheet" href="{$url}application/themes/admin/css/login.css" type="text/css" />

		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.js"></script>
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
				<center>
					<div class="center_1020">
						<a href="{$url}admin" class="logo"></a>

						<!-- Top menu -->
						<aside class="right">
							<nav>
							</nav>

							<div class="welcome">
								Welcome, <b>{if $isOnline}{ucfirst($username)}{else} Unknown{/if}</b>
							</div>
						</aside>
					</div>
				</center>
				</header>

				<div id="content">
					<h1>Welcome to the ACP</h1>

					<form onSubmit="Login.send(this); return false">
					<center>
						<input type="text" placeholder="Username" {if $isOnline}disabled value="{$username}"{/if} id="username"/>
						<input type="password" placeholder="Password" {if $isOnline}disabled value="Password"{/if} id="password"><input type="password" placeholder="Security code" id="security_code" />
						</br><input type="submit" value="Enter ACP" />
							</br></br><a href="{$url}">Back to Site</a> | <a href="https://gitlab.com/omghixd/fusiongen">FusionGEN Gitlab</a> | <a href="https://gitlab.com/omghixd/fusiongen/issues?scope=all&utf8=%E2%9C%93&state=all&label_name[]=Solution">Solution Center</a>
					</center>
					</form>
				</div>
			</div>
		</div>

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
<!DOCTYPE html>
<html class="fixed dark">
	<head>
		<title>Login - ACP</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/images/fusiongen.png">

		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/theme.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/css/skins/default.css">
		<link rel="stylesheet" href="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/css/sweetalert2-dark.css">
		
		<!-- JS -->
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/jquery/jquery.min.js"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/js/login.js" type="text/javascript"></script>
		<script src="{if $cdn_link != false}{$cdn_link}{else}{$url}{/if}application/themes/admin/assets/vendor/sweetalert2/js/sweetalert2.js"></script>

		<script type="text/javascript">
		function getCookie(c_name) {
			var i, x, y, ARRcookies = document.cookie.split(";");

			for(i = 0; i < ARRcookies.length;i++) {
				x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
				y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
				x = x.replace(/^\s+|\s+$/g,"");

				if(x == c_name) {
					return unescape(y);
				}
			}
		}

		var Config = {
			URL: "{$url}",
			CSRF: getCookie('csrf_cookie_name'),
		};
		
		</script>
	</head>
	
	<body>
	<section class="body-sign body-locked">
		<div class="center-sign">
			<div class="panel card-sign">
				<div class="card-body">
					<form onSubmit="Login.send(this); return false">
						<div class="current-user text-center">
							<img src="{$avatar}" class="rounded-circle user-image" />
							<h2 class="user-name text-dark m-0">{$username}</h2>
						</div>
						<p class="text-center" id="error">
						</p>
						<div class="form-group mb-3">
							<div class="input-group">
								<input type="password" id="security_code" name="security_code" class="form-control" placeholder="Security Code" autocomplete="off" autofocus required>
								<span class="input-group-text">
									<i class="fas fa-lock"></i>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<p class="mt-1 mb-3">
									<a href="../">Not {$username}?</a>
								</p>
							</div>
							<div class="col-6">
								<button type="submit" class="btn btn-primary pull-right">Login</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	</body>
</html>
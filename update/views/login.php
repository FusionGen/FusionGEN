<!DOCTYPE html>
<html>
	<head>
		<title>Update FusionCMS</title>
		<link rel="shortcut icon" type="image/png" href="static/images/favicon.png">
		<link rel="stylesheet" type="text/css" href="static/css/login.css">
		<!--[if lt IE 9]>
			<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body>
		<section id="wrapper">
			<header>FusionCMS</header>
			<div class="info_bar">You are currently running version <span class="tag"><?php echo Update::$currentVersion; ?></span></div>
			
			<section id="main">
				<form class="login" method="post" action="">
					<input type="password" name="password" placeholder="Enter update password" />
					<input type="submit" value="Enter">

					<?php if(isset($wrongPassword) && $wrongPassword) { ?>
						<div class="error">
							The password is incorrect.
						</div>
					<?php } ?>

					<div class="info">
						The update password can be found in the <b>update_password.php</b> file located in the <b>updates</b> folder.
						Open the file with a text editor such as notepad to see the password.
					</div>
				</form>
			</section>
		</section>
	</body>
</html>
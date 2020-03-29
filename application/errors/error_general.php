<!DOCTYPE html>
<html lang="en">
<head>
<title>Error</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #19191b;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #fff;
}

a {
	color: #fff;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #fff;
	text-transform: uppercase;
	font-weight: bold;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	color: #fff;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border-radius: 2px;
}

p {
	margin: 12px 15px 12px 15px;
	font-style: italic;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>
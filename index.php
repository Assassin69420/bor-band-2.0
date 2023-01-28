<?php
$page = "home";

session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$user_id = $_SESSION["user_id"];
} else {
	header("location: login.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MyWebsite</title>
	<link rel="stylesheet" href="home.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Bubblegum+Sans|Caveat+Brush|Chewy|Lobster+Two');

		body {
			width: 100%;
			height: 100%;
			background: linear-gradient(#141e30, #243b55);
		}

		html {
			width: 100%;
			height: 100%;
		}

		.navbar {
			background: linear-gradient(135deg, #141e30, #03e9f4, #141e30);
			border: 0;
			z-index: 9999;
			letter-spacing: 4px;

		}

		.logo {
			display: block;
			height: auto;
			width: 52px;
			padding-top: 5px;
			margin-right: 15px;
		}

		.navbar-brand>img {
			height: 100%;
			padding: 15px;
			/* firefox bug fix */
			width: auto;
		}

		.navbar .nav>li>a {
			line-height: 50px;
		}

		.navbar-header h1 {
			letter-spacing: 1px;
			color: black !important;
			font-family: 'Lobster Two', cursive;
		}

		.navbar li a,
		.navbar {
			color: black !important;
			font-size: 12px;
			transition: all 0.6s 0s;
		}

		.navbar-toggle {
			background-color: transparent !important;
			border: 0;
		}

		.navbar-nav li a:hover,
		.navbar-nav li a.active {
			color: white !important;
		}

		.img {
			margin-left: 24.5%;
			height: auto;
		}

		body {
			-webkit-font-smoothing: antialiased;
			text-rendering: optimizeLegibility;
			font-family: "proxima-nova-soft", sans-serif;
			user-select: none;
			overflow: hidden;
		}

		body .vertical-centered-box {
			position: absolute;
			width: 100%;
			height: 100%;
			text-align: center;
			z-index: -20;
		}

		body .vertical-centered-box:after {
			content: '';
			display: inline-block;
			height: 100%;
			vertical-align: middle;
			margin-right: -0.25em;
		}

		body .vertical-centered-box .content {
			box-sizing: border-box;
			display: inline-block;
			vertical-align: middle;
			text-align: left;
			font-size: 0;
		}

		* {
			transition: all 0.3s;
		}

		#particles-background,
		#particles-foreground {
			left: -51%;
			top: -51%;
			width: 202%;
			height: 202%;
			transform: scale3d(0.5, 0.5, 1);
		}

		#particles-background {
			background: #2c2d44;
			background-image: -moz-linear-gradient(45deg, #141e30, #243b55);
			background-image: -webkit-linear-gradient(45deg, #141e30, #243b55);
			background-image: linear-gradient(45deg, #141e30, #243b55);
		}

		@keyframes rotate {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		@keyframes fade {
			0% {
				opacity: 1;
			}

			50% {
				opacity: 0.25;
			}
		}

		@keyframes fade-in {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}
	</style>
</head>

<body>
	<?php include_once 'components/navbar.php' ?>
	<div class="con">
		<div class="loader-weight">
			<h1>Check Internet Speed</h1>
			<span class="loader hide"></span>
			<div class="loader-content">
				<div class="content hide">24<small>Mbps</small></div>
				<button type="button" id="mybt" onclick="start()">GO</button>
			</div>
		</div>
	</div>
	<div>
		<h4 class="bot">By continuing past this page, you agree to our Terms of Service, Cookie Policy, Privacy Policy and
			Content Policies. All trademarks are properties of their respective owners. 2023 © Bro Band™ Ltd. All rights
			reserved.</h4>
	</div>
	</div>
	</div>
	<div id="particles-background" class="vertical-centered-box"></div>
	<div id="particles-foreground" class="vertical-centered-box"></div>
	<script src="loading.js"></script>
	<script src="home.js"></script>

</body>

</html>

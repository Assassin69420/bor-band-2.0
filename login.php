<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	header("location: index.php");
	exit;
}

// Include config file
require_once "db.php";

$phone = $password = "";
$phone_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty(trim($_POST["phone"]))) {
		$phone_err = "Please enter phone number.";
	} else {
		$phone = trim($_POST["phone"]);
	}

	if (empty(trim($_POST["password"]))) {
		$password_err = "Please enter your password.";
	} else {
		$password = trim($_POST["password"]);
	}

	if (empty($phone_err) && empty($password_err)) {
		$sql = "SELECT user_id, phone, password FROM ulogin WHERE phone = ?";

		if ($stmt = mysqli_prepare($db, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_phone);

			$param_phone = $phone;
			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $user_id, $phone, $stored_password);
					if (mysqli_stmt_fetch($stmt)) {
						if ($password == $stored_password) {
							session_start();

							$_SESSION["loggedin"] = true;
							$_SESSION["phone"] = $phone;
							$_SESSION["user_id"] = $user_id;

							header("location: index.php");
						} else {
							$login_err = "Invalid phone number or password.";
						}
					}
				} else {
					$login_err = "Invalid phone number or password.";
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}

	mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style>
		html {
			height: 100%;
		}

		body {
			margin: 0;
			padding: 0;
			font-family: sans-serif;
			background: linear-gradient(#141e30, #243b55);
		}

		.login-box {
			position: absolute;
			top: 50%;
			left: 50%;
			width: 400px;
			padding: 40px;
			transform: translate(-50%, -50%);
			background: rgba(0, 0, 0, .5);
			box-sizing: border-box;
			box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
			border-radius: 10px;
		}

		.login-box h2 {
			margin: 0 0 30px;
			padding: 0;
			color: #fff;
			text-align: center;
		}

		.login-box .user-box {
			position: relative;
		}

		.login-box .user-box input {
			width: 100%;
			padding: 10px 0;
			font-size: 16px;
			color: #fff;
			margin-bottom: 30px;
			border: none;
			border-bottom: 1px solid #fff;
			outline: none;
			background: transparent;
		}

		.login-box .user-box label {
			position: absolute;
			top: 0;
			left: 0;
			padding: 10px 0;
			font-size: 16px;
			color: #fff;
			pointer-events: none;
			transition: .5s;
		}

		.login-box .user-box input:focus~label,
		.login-box .user-box input:valid~label {
			top: -20px;
			left: 0;
			color: #03e9f4;
			font-size: 12px;
		}

		.login-box form button {
			position: relative;
			display: inline-block;
			padding: 10px 20px;
			color: #03e9f4;
			font-size: 16px;
			text-decoration: none;
			text-transform: uppercase;
			overflow: hidden;
			background: none;
			border: none;
			transition: .5s;
			margin-top: 40px;
			letter-spacing: 4px
		}

		.login-box button:hover {
			background: #03e9f4;
			color: #fff;
			border-radius: 5px;
			box-shadow: 0 0 5px #03e9f4,
				0 0 25px #03e9f4,
				0 0 50px #03e9f4,
				0 0 100px #03e9f4;
		}

		.login-box button span {
			position: absolute;
			display: block;
		}

		.login-box button span:nth-child(1) {
			top: 0;
			left: -100%;
			width: 100%;
			height: 2px;
			background: linear-gradient(90deg, transparent, #03e9f4);
			animation: btn-anim1 1s linear infinite;
		}

		@keyframes btn-anim1 {
			0% {
				left: -100%;
			}

			50%,
			100% {
				left: 100%;
			}
		}

		.login-box button span:nth-child(2) {
			top: -100%;
			right: 0;
			width: 2px;
			height: 100%;
			background: linear-gradient(180deg, transparent, #03e9f4);
			animation: btn-anim2 1s linear infinite;
			animation-delay: .25s
		}

		@keyframes btn-anim2 {
			0% {
				top: -100%;
			}

			50%,
			100% {
				top: 100%;
			}
		}

		.login-box button span:nth-child(3) {
			bottom: 0;
			right: -100%;
			width: 100%;
			height: 2px;
			background: linear-gradient(270deg, transparent, #03e9f4);
			animation: btn-anim3 1s linear infinite;
			animation-delay: .5s
		}

		@keyframes btn-anim3 {
			0% {
				right: -100%;
			}

			50%,
			100% {
				right: 100%;
			}
		}

		.login-box button span:nth-child(4) {
			bottom: -100%;
			left: 0;
			width: 2px;
			height: 100%;
			background: linear-gradient(360deg, transparent, #03e9f4);
			animation: btn-anim4 1s linear infinite;
			animation-delay: .75s
		}

		@keyframes btn-anim4 {
			0% {
				bottom: -100%;
			}

			50%,
			100% {
				bottom: 100%;
			}
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
		.reset{
	margin-left: 70px;
}
p {
	color: white;
	margin-top: 30px;
	text-align: center;
}
p a{
	color: #03e9f4;
	text-decoration: none;
}
	</style>
</head>

<body>
	<div class="login-box">
		<h2>Login</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="user-box">
				<input type="text" name="phone" required="true" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
				<label>Phone</label>
			</div>
			<div class="user-box">
				<input type="password" name="password" required="true" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
				<label>Password</label>
			</div>
			<button type="submit" value="Submit">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				Submit
			</button>
			<p>Don't have an account? <a href="register.php">register here</a>.</p>
		</form>
	</div>
	<div id="particles-background" class="vertical-centered-box"></div>
	<div id="particles-foreground" class="vertical-centered-box"></div>
	<script src="loading.js"></script>

</body>

</html>

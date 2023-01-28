<?php
include('db.php');
include('services/plan_services.php');
include('services/user_services.php');

session_start();

$phone = "";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$phone = $_SESSION["phone"];
	$user_id = $_SESSION["user_id"];

	$user_hist = get_user_history($user_id, $db);
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
	<link rel="stylesheet" href="any.css">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/layout.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Bubblegum+Sans|Caveat+Brush|Chewy|Lobster+Two');

		.profile-card-ctr {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 40px;
			flex-direction: column;
			min-height: 30rem;
			min-width: 10rem;
			background: white;
			border-radius: 3%;
		}

		.cards-table {
			margin-top: 10rem;
			display: flex;
			flex-direction: column;
			gap: 1rem;
		}

		@media screen and (max-width: 576px) {
			.profile-card-ctr {
				flex-wrap: wrap;
			}
		}

		.profile-card__button {
			background: none;
			border: none;
			font-family: "Quicksand", sans-serif;
			font-weight: 700;
			font-size: 19px;
			margin: 15px 45px;
			padding: 15px 40px;
			min-width: 201px;
			border-radius: 50px;
			min-height: 55px;
			color: #fff;
			cursor: pointer;
			backface-visibility: hidden;
			transition: all 0.3s;

			margin-top: auto;
			padding-bottom: 1rem;
			margin-bottom: 2rem;
		}

		.profile-card-ctr {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 40px;
		}

		@media screen and (max-width: 576px) {
			.profile-card-ctr {
				flex-wrap: wrap;
			}
		}

		.profile-card__button:focus {
			margin-left: 10px;
			outline: none !important;
		}

		@media screen and (min-width: 768px) {
			.profile-card__button:hover {
				transform: translateY(-8px);
			}
		}

		.profile-card__button.button--orange {
			background: linear-gradient(45deg, #141e30, #243b55);
			box-shadow: 0px 4px 30px #141e30;
		}

		.profile-card__button.button--orange:hover {
			box-shadow: 0px 7px 30px #03e9f4;
		}

		.td {
			padding-left: 110px;
		}

		.ts {
			padding-left: 210px;
		}

		.title {
			font-size: 34px;
			color: #03e9f4;
			margin-bottom: 80px;
		}

		.plansservices_display {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			flex-grow: 0;
		}

		.card-info {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.plan-cards {
			display: flex;
			flex-direction: row;
			gap: 1rem;
			flex-wrap: wrap;
		}

		.plansservice_card {
			color: #03e9f4;
			display: flex;
			flex-direction: column;
			background: linear-gradient(45deg, #141e30, #243b55);
			border-radius: 6px;
			position: relative;
			padding: 2rem;
			align-items: flex-start;
			gap: 3rem;
			margin-right: 20px;
		}

		.stats {
			align-self: stretch;
			display: grid;
			grid-template-columns: 1fr 1fr;
			justify-content: space-between;
			column-gap: 10rem;
		}

		.plan-status {
			padding: 0.5rem 1rem;
			background-color: #ADE792;
			color: #141e30;
			border-top-left-radius: 55% 45px;
			border-bottom-left-radius: 55% 45px;
			border-top-right-radius: 55% 45px;
			border-bottom-right-radius: 55% 45px;
			text-align: center;
		}

		.plan-name {
			line-height: 4rem;
			margin: unset;
			font-weight: bold;
			font-size: 25px;
		}

		.plan-name span {
			display: block;
			font-size: 30px;
		}
		.navbar .nav>li>a {
		line-height: 50px;
		padding: 0px 14px;
		font-size: 12px;
		transition: all 0.6s 0s;
		}
		@property --rotate {
  			syntax: "<angle>";
  			initial-value: 132deg;
  			inherits: false;
		}
		:root {
			--card-height: 65vh;
			--card-width: calc(var(--card-height) / 1.5);
		}
		.plansservice_card::before {
  content: "";
  width: 104%;
  height: 102%;
  border-radius: 8px;
  background-image: linear-gradient(
    var(--rotate)
    , #5ddcff, #3c67e3 43%, #4e00c2);
    position: absolute;
    z-index: -1;
    top: -1%;
    left: -2%;
    animation: spin 2.5s linear infinite;
}
.plansservice_card::after {
  position: absolute;
  content: "";
  top: calc(var(--card-height) / 6);
  left: 0;
  right: 0;
  z-index: -1;
  height: 100%;
  width: 100%;
  margin: 0 auto;
  transform: scale(0.8);
  filter: blur(calc(var(--card-height) / 6));
  background-image: linear-gradient(
    var(--rotate)
    , #5ddcff, #3c67e3 43%, #4e00c2);
    opacity: 1;
  transition: opacity .5s;
  animation: spin 2.5s linear infinite;
}

@keyframes spin {
  0% {
    --rotate: 0deg;
  }
  100% {
    --rotate: 360deg;
  }
}

	</style>
</head>

<body>
	<?php include_once 'components/navbar.php' ?>
	<div class="cards-table">

		<?php if ($user_hist[1]->num_rows > 0) : ?>
			<div class="plansservices_display">
				<h2 class="title">Active Plans</h2>
				<div class="plan-cards">
					<?php
					while ($obj = $user_hist[1]->fetch_object()) {
						echo '
							<div class="plansservice_card">
									<span class="plan-status">🗸 ACTIVE</span>
									<h2 class="plan-name">
										Your current plan is:
										<span>
										' .
							$obj->plan_name . '
										</span>
									</h2>

									<div class="stats">
										<p class="stat">Speed: ' .
							$obj->internet_speed . 'Mbps
										</p>
										<p class="stat">FUP Limit: ' .
							$obj->fup_limit . '
										</p>
										<p class="stat">Price: ₹' .
							$obj->plan_cost . '
										</p>
										<p class="stat">Billing: ' .
							$obj->min_first_bill_period . '
										</p>
									</div>

									<form action="bills.php" method="POST">
										<button class="profile-card__button button--orange">View bill</button>
										<input type="hidden" name="related_plan_id" value="' . $obj->plan_id . '">
									</form>
							</div>
						';
					}
					?>
				</div>
			</div>
		<?php endif ?>

		<?php if ($user_hist[0]->num_rows > 0) : ?>
			<div class="plansservices_display">
				<h2 class="title">Active Services</h2>
				<div class="plan-cards">
					<?php
					while ($obj = $user_hist[0]->fetch_object()) {
						echo '
							<div class="plansservice_card">
									<span class="plan-status">🗸 ACTIVE</span>
									<h2 class="plan-name">
										Your current service is:
										<span>
										' .
							$obj->service_name . '
										</span>
									</h2>

									<div class="stats">
										<p class="stat">Tarrif: ₹' .
							$obj->service_cost . '
										</p>
										<p class="stat">Date of purchase: ' .
							$obj->date_of_purchase . '
										</p>
									</div>

									<form action="bills.php" method="POST">
										<button>View bill</button>
										<input type="hidden" name="related_plan_id" value="' . $obj->plan_id . '">
									</form>
							</div>
						';
					}
					?>
				</div>
			</div>
		<?php endif ?>
	</div>

	<script src="home.js"></script>

</body>

</html>

<?php
include('db.php');
include('services/broband_servies.php');

$all_plans = get_all_offered_internet_plans($db);
$page = "plans";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MyWebsite</title>
	<link rel="stylesheet" href="any.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Bubblegum+Sans|Caveat+Brush|Chewy|Lobster+Two');
		@property --rotate {
  			syntax: "<angle>";
  			initial-value: 132deg;
  			inherits: false;
		}
		:root {
			--card-height: 65vh;
			--card-width: calc(var(--card-height) / 1.5);
		}
		.profile-card-ctr::before {
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
.profile-card-ctr::after {
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


		.cards-table {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 1rem;
			color: #03e9f4;
			background: none;
			border-radius: 15px;
			padding: 50px;
			margin-top: 10rem;
			margin-right: auto;
			margin-left: auto;
			align-items: flex-start;
		}

		.plan-name {
			padding: 2.5rem;
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
			margin: 15px 35px;
			padding: 15px 40px;
			min-width: 201px;
			border-radius: 50px;
			min-height: 55px;
			color: #fff;
			cursor: pointer;
			backface-visibility: hidden;
			transition: all 0.3s;

			margin-top: auto;
		}

		.profile-card-ctr {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 10px;
			position: relative;
			flex-direction: column;
			min-height: 360px;
			min-width: 280px;
			background: linear-gradient(45deg, #141e30, #243b55);
			border-radius: 3%;
			gap: 1.5rem;
		}

		@media screen and (max-width: 576px) {
			.profile-card-ctr {
				flex-wrap: wrap;
			}
		}

		.profile-card__button:focus {
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

		.plan_deets {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}
		.navbar .nav>li>a {
		line-height: 50px;
		padding: 0px 14px;
		font-size: 11.7px;
		transition: all 0.6s 0s;
		text-decoration: none;
	}

	</style>
</head>

<body>
	<?php include_once 'components/navbar.php' ?>
	<div>
		<div class="cards-table">
			<?php
			while ($obj = $all_plans->fetch_object()) {
				echo '
				<form class="profile-card-ctr" action="confirm_purchase.php" method="POST">
					<div class="card-info">
						<h2 class="plan-name">
'
					. $obj->plan_name
					. '
						</h2>
<div>
<h4 class="plan_deets"><span>Speed</span><span>' . $obj->internet_speed . '</span></h4>
<h4 class="plan_deets"><span>FUP limit</span><span>' . $obj->fup_limit . '</span></h4>
<h4 class="plan_deets"><span>Min period</span><span>' . $obj->min_first_bill_period . '</span></h4>
</div>
					</div>
<h4>₹' . $obj->cost . '</h4>
					<input type="hidden" name="plan" value="' . $obj->id . '">
					<button type="submit" class="profile-card__button button--orange">Activate</button>
				</form>';
			}
			?>
		</div>
	</div>

	<script src="home.js"></script>

</body>

</html>

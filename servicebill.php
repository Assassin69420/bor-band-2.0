<?php
include('db.php');
include('services/bills_services.php');

session_start();

$phone = "";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$phone = $_SESSION["phone"];
	$user_id = $_SESSION["user_id"];
	$related_service_id = $related_plan_id = "";

	if (isset($_POST["related_plan_id"]) && $_POST["related_plan_id"] !== '') {
		$related_plan_id = $_POST["related_plan_id"];
	} else if (isset($_POST["related_service_id"]) && $_POST["related_service_id"] !== '') {
		$related_service_id = $_POST["related_service_id"];
	}

	$bill = get_bill_userplanid(related_plan_id: $related_plan_id, related_service_id: $related_service_id, db: $db);
	$cgst_amount = ($bill->cgst_percentage / 100) * $bill->amount;
	$sgst_amount = ($bill->sgst_percentage / 100) * $bill->amount;
	$total_cost = $cgst_amount + $sgst_amount + $bill->amount;
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

		td {
			padding: 2rem;
			border: 1px solid #03e9f4;
		}

		.profile-card-ctr {
			color: #03e9f4;
			display: flex;
			position: relative;
			justify-content: center;
			align-items: center;
			margin-top: 40px;
			flex-direction: column;
			min-height: 30rem;
			min-width: 10rem;
			background: linear-gradient(45deg, #141e30, #243b55);
			border-radius: 3%;
			padding: 0 5rem;
		}

		.cards-table {
			margin-top: 10rem;
			display: flex;
			flex-direction: column;
			gap: 1rem;
		}

		.plan-name {
			margin-top: 1.5rem;
			padding: 2.5rem;
		}

		@media screen and (max-width: 576px) {
			.profile-card-ctr {
				flex-wrap: wrap;
			}
		}

		.td {
			padding-left: 110px;
		}

		.ts {
			padding-left: 210px;
		}

		.title {
			color: white;
		}

		.plansservices_display {
			display: flex;
			flex-direction: column;
			align-items: center;
			position: relative;
			justify-content: center;
			flex-grow: 0;
			color: #03e9f4;
		}

		.card-info {
			display: flex;
			align-items: center;
			padding-bottom: 20px;
			color: #03e9f4
		}
		.navbar .nav>li>a {
		line-height: 50px;
		padding: 0px 14px;
		font-size: 11.7px;
		transition: all 0.6s 0s;
		text-decoration: none;
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

	
	</style>
</head>
<body>
<?php include_once 'components/navbar.php' ?>
<section class="cards-table">

<div class="plansservices_display">
    <div class="profile-card-ctr">
    <h1><?php echo $bill->service_name ?></h1>
        <div class="card-info">
            <table>
                <tr>
                    <td>Total Charges</td>
                    <td>₹<?php echo $bill->amount ?></td>
                </tr>
                <tr>
                    <td>cgst 9.5%</td>
                    <td>₹<?php echo $cgst_amount; ?></td>
                </tr>
                <tr>
                    <td>sgst 9.5%</td>
                    <td>₹<?php echo $sgst_amount; ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>₹<?php echo $total_cost; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</section>
</body>
</html>
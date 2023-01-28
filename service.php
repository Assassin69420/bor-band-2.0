<?php
include('db.php');
include('services/broband_servies.php');

$all_services = get_all_offered_services($db);
$page = "service";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MyWebsite</title>
	<link rel="stylesheet" href="service.css">
	<link rel="stylesheet" href="profile.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
		@property --rotate {
  			syntax: "<angle>";
  			initial-value: 132deg;
  			inherits: false;
		}
		:root {
			--card-height: 65vh;
			--card-width: calc(var(--card-height) / 1.5);
		}
		.service_card::before {
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
.service_card::after {
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
		.service_card {
			flex-grow: 0;
			width: 280px;
			height: 300px;
			flex-direction: column;
			align-items: flex-start;
			align-items: center;
			padding: 1rem;
			background: linear-gradient(45deg, #141e30, #243b55);
			color: black;
			border-radius: 6px;
			position: relative;
			content: "";
			overflow: visible;
		}

		.profile-card__button {
			margin-top: 40px;
			margin: unset !important;
		}


		.service_card_img img {
			max-height: 100%;
			max-width: 100%;
		}

		.service_card-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 1rem;
			color: white;
			background: none;
			border-radius: 15px;
			padding: 50px;
			margin-top: 10rem;
			margin-right: auto;
			margin-left: auto;
			align-items: flex-start;
		}

		.label-text-container {
			display: flex;
			flex-direction: column;
			background: none;
			align-items: center;
			color: #03e9f4;

			gap: 0.7rem;
			margin-bottom: 40px;
		}

		.label-text {
			font-size: 17px;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<?php include_once 'components/navbar.php' ?>
	<div class="service_card-container">
		<?php
		while ($obj = $all_services->fetch_object()) {
			echo '
						 <form class="service_card" action="confirm_purchase.php" method="POST">
						    <div class="">
							 <p class="label-text-container"> 
								<span class="label-text">Service Name </span>
								<span class="label-value">' . $obj->service_name . '</span>
							 </p>
							 <p class="label-text-container">
									<span class="label-text">Amount </span><span class="label-value">₹' . $obj->cost . '</span>
							 </p>
							 <input type="hidden" name="service" value="' . $obj->id . '">
							 <button type="submit" class="profile-card__button button--orange">Purchase</button>
							</div>
						 </form>
					  ';
		}
		?>
	</div>

</body>

</html>

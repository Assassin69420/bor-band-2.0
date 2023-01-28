<?php
include('../db.php');
include('broband_servies.php');
include('plan_services.php');
include('user_services.php');

session_start();

$phone = "";
$page = "plans";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$phone = $_SESSION["phone"];
	$user_id = $_SESSION["user_id"];
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["plan"]) && $_POST["plan"] !== '') {
			$plan_id = $_POST["plan"];
			purchase_plan(user_id: $user_id, plan_id: $plan_id, db: $db);
			header("location: /your_plan.php");
		} else if (isset($_POST["service"]) && $_POST["service"] !== '') {
			$service_id = $_POST["service"];
			purchase_service(user_id: $user_id, service_id: $service_id, service_period: null, db: $db);
			header("location: /your_plan.php");
		}
	} else {
		header("location: /plans.php");
		exit;
	}
} else {
	header("location: login.php");
	exit;
}

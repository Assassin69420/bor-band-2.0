<?php
function get_plan_details(string $plan_id, mysqli $db)
{
	$sql = "SELECT id, plan_name, details, internet_speed, cost, fup_limit, min_first_bill_period from internet_plans where id='$plan_id'";
	$res = $db->query($sql);
	return $res->fetch_object();
}

function get_service_details(string $service_id, mysqli $db)
{
	$sql = "SELECT id, service_name, cost from services where id='$service_id'";
	$res = $db->query($sql);
	return $res->fetch_object();
}

function purchase_plan(string $user_id, string $plan_id, mysqli $db)
{
	$plan_details = get_plan_details($plan_id, $db);
	$create_bill_sql = "INSERT INTO bills
												(user_id, amount, due_date, paid_date, related_service, related_plan, cgst_percentage, sgst_percentage)
											VALUES
												('$user_id','$plan_details->cost', NOW(), NOW(), null, '$plan_id', 9.5, 9.5)";

	try {
		$db->query($create_bill_sql);
		$bill_id = $db->insert_id;

		$track_plan_sql = "INSERT INTO user_plan_tracker (user_id,plan_id,date_of_purchase,purchase_bill) VALUES ('$user_id','$plan_id',NOW(),'$bill_id')";

		$db->query($track_plan_sql);
		$db->commit();

		$bill_sql = "SELECT bill_id, user_id, amount, due_date,
												paid_date, related_service, related_plan,
												cgst_percentage, sgst_percentage FROM bills
								 WHERE bill_id='$bill_id'";
		$bill_res = $db->query($bill_sql);
		return $bill_res->fetch_object();
	} catch (mysqli_sql_exception $exception) {
		$db->rollback();
		throw $exception;
	}
}

function purchase_service(string $user_id, string $service_id, null|string $service_period, mysqli $db)
{
	$service_details = get_service_details($service_id, $db);
	$create_bill_sql = "INSERT INTO bills
												(user_id, amount, due_date, paid_date, related_service, related_plan, cgst_percentage, sgst_percentage)
											VALUES
												('$user_id','$service_details->cost', NOW(), NOW(), '$service_id', null, 9.5, 9.5)";


	try {
		$db->query($create_bill_sql);
		$bill_id = $db->insert_id;

		$track_service_sql = "INSERT INTO user_service_tracker (user_id,service_id,service_period,date_of_purchase,purchase_bill) VALUES ('$user_id','$service_id','$service_period',NOW(),$bill_id)";

		$db->query($track_service_sql);

		$db->commit();

		$bill_sql = "SELECT bill_id, user_id, amount, due_date,
												paid_date, related_service, related_plan,
												cgst_percentage, sgst_percentage FROM bills
								 WHERE bill_id='$bill_id'";
		$bill_res = $db->query($bill_sql);
		return $bill_res->fetch_object();
	} catch (mysqli_sql_exception $exception) {
		$db->rollback();
		throw $exception;
	}
}

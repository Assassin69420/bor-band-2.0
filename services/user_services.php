<?php
function get_user_details(string $phone, mysqli $db)
{

	$data = null;
	$sql = "SELECT id as user_id, name, address from useraccount where phone='$phone'";

	$res = mysqli_query($db, $sql);
	$data = $res->fetch_object();
	return $data;
}

function get_user_history(string $user_id, mysqli $db)
{
	$services_history = "SELECT US.user_id, S.service_name, US.service_period, US.date_of_purchase, S.cost as service_cost, US.service_id
											FROM user_service_tracker US
												INNER JOIN services	S on S.id = US.service_id
											WHERE US.user_id = '$user_id' ORDER BY US.date_of_purchase desc";

	$plans_history = "SELECT PS.user_id, PS.date_of_purchase, P.cost as plan_cost, PS.plan_id,
													 P.plan_name, P.details, P.internet_speed, P.fup_limit, P.min_first_bill_period
									 FROM user_plan_tracker PS
										 INNER JOIN internet_plans P on P.id = PS.plan_id
									 WHERE PS.user_id = '$user_id' ORDER BY PS.date_of_purchase desc";

	$services_res = mysqli_query($db, $services_history);
	$plans_res = mysqli_query($db, $plans_history);

	return array($services_res, $plans_res);
}

function register_user(string $phone, string $name, string $address, string $password, mysqli $db)
{
	$create_account_sql = "INSERT INTO useraccount
													(id, name, address, phone)
												VALUES
													(DEFAULT, '$name','$address','$phone')";

	$db->begin_transaction();
	try {
		$res = $db->query($create_account_sql);
		$user_id = $db->insert_id;
		if (isset($user_id)) {
			$sql = 'SELECT * FROM useraccount';
			$create_login_sql = "INSERT INTO ulogin (user_id, phone, password) VALUES ('$user_id','$phone','$password')";
			$u_res = $db->query($create_login_sql);
			$db->commit();
			return $user_id;
		} else {
			$db->rollback();
			throw 'some error';
		}
	} catch (mysqli_sql_exception $exception) {
		$db->rollback();
		throw $exception;
	}
}

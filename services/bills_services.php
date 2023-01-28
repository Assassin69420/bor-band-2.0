<?php

function get_bill_userplanid(string|null $related_plan_id, string|null $related_service_id, mysqli $db)
{

	if ($related_plan_id !== "") {
		$sql = "SELECT bill_id, user_id, amount, due_date, paid_date, related_plan, cgst_percentage, sgst_percentage,plan_name as ps_name, U.name as username, U.id as account_id
						FROM bills B
						INNER JOIN useraccount U ON U.id = B.user_id
						INNER JOIN internet_plans P ON P.id = B.related_plan
						WHERE related_plan='$related_plan_id'";
	} else if ($related_service_id !== "") {
		$sql = "
						SELECT bill_id, user_id, amount, due_date, paid_date, related_plan, cgst_percentage, sgst_percentage, service_name as ps_name, U.name as username, U.id as account_id FROM bills B
						INNER JOIN useraccount U ON U.id = B.user_id
						INNER JOIN services S ON S.id = B.related_service
						WHERE related_service='$related_service_id'";
	} else {
		throw new Exception('related_plan and related_service not set');
	}

	$res = mysqli_query($db, $sql);
	return $res->fetch_object();
}

<?php
function get_all_offered_services(mysqli $db)
{
	$sql = "SELECT id, service_name, cost FROM services";
	$res = $db->query($sql);
	return $res;
}

function get_all_offered_internet_plans($db)
{
	$sql = "SELECT id, plan_name, details, internet_speed, cost, fup_limit, min_first_bill_period from internet_plans";
	$res = $db->query($sql);
	return $res;
}

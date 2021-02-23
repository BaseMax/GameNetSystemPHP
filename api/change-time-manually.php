<?php
require "../_core.php";

$orderID = $_POST["orderID"];
$time = $_POST["time"];
$daste = $_POST["daste"];

$clauses = [
	"id"=>$orderID,
];
$order = $db->select("orders", $clauses);
if($order == null || $order == []) {
	// header("Location: index.php");
	exit();
}

// print_r($order);

if($order["endTime"] == "" || $order["endTime"] == null) {
	$endTime = jmktime();
}
else {
	$endTime = (int) $order["endTime"];
}

$startTime = $endTime - ($time * 60);

$values = [
	"startTime"=>$startTime,
];


if($order["endTime"] != "" && $order["endTime"] != null) {
	$values["endTime"]=$endTime;
}

$values["planDaste"] = $daste;
$in_daste = $db->select("plans", ["id"=>$order["planID"]]);
$price = $in_daste["price".$daste];
$values["planPrice"] = $price;

// print_r($_POST);
// print_r($values);

$db->update("orders", $clauses, $values);

print "تغییر زمان انجام شد.";

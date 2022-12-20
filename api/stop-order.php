<?php
require "../_core.php";

// print_r($_POST);

$clauses = [
	"id"=>$_POST["orderID"],
];
$order = $db->select("orders", $clauses);
// print_r($order);
$db->update("orders", $clauses, ["endTime"=>mytime(), "has_canceled"=>1]);

print "سفارش متوقف شد.";

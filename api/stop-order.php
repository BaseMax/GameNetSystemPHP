<?php
require "../_core.php";

// print_r($_POST);

$clauses = [
	"id"=>$_POST["orderID"],
];
$order = $db->select("orders", $clauses);
// print_r($order);
$db->update("orders", $clauses, ["endTime"=>jmktime()]);

print "سفارش متوقف شد.";

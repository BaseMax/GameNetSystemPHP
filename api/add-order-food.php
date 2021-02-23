<?php
require "../_core.php";

// print_r($_POST);

$last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." AND `endTime` IS NULL ORDER BY `id` DESC;");
if($last_order == null || $last_order == []) {
	$values=[
	];
	$playID = $db->insert("plays", $values);
}
else {
	// $playID = 1;
	$playID = $last_order["playID"];
}
// print_r($last_order);

$clauses = [
	"id"=>$playID,
];
$play = $db->select("plays", $clauses);

$food = $db->select("foods", ["id"=>$_POST["food"]]);
if($food == [] || $food == null) {
	exit("Error in food ID!\n");
}

$clauses = [
	"playID"=>$play["id"],
	"foodID"=>$_POST["food"],
];
$values = [
	"playID"=>$play["id"],
	"foodID"=>$_POST["food"],
	"count"=>(int)$_POST["count"],
	"price"=>$food["sale"],
];
if($db->count("orders_food", $clauses) == 0) {
	$db->insert("orders_food", $values);
}
else {
	$order = $db->select("orders_food", $clauses);
	$order["count"] = (int) $order["count"];
	$values["count"] = $order["count"] + $values["count"];
	$db->update("orders_food", $clauses, $values);
}

print "سفارش با موفقیت ثبت شد.";

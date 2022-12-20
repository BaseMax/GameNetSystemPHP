<?php
require "../_core.php";

// print_r($_POST);

// $playID = 1;
// $clauses = [
// 	"id"=>$playID,
// ];
// $play = $db->select("plays", $clauses);


// $last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." AND `status` = 1 ORDER BY `id` DESC;");
// $last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." AND ((`timer` = 0 AND `endTime` IS NULL) or (`timer` = 1)) AND `status` = 1 ORDER BY `id` DESC;");
$last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." AND ((`timer` = 0 AND `endTime` IS NULL AND `has_canceled` = 0) or (`timer` = 0 AND `endTime` IS NOT NULL AND `has_canceled` = 1) or (`timer` = 1)) AND `status` = 1 ORDER BY `id` DESC;");
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



$clauses = [
	"family"=>$_POST["planFamily"],
	"name".$_POST["planDasteIndex"]=>$_POST["planDasteName"],
];
$plan = $db->select("plans", $clauses, "", "id, price".$_POST["planDasteIndex"]);
// print_r($plan);

$clauses = [
	"playID"=>$play["id"],
];
$orders = $db->selects("orders", $clauses);
foreach($orders as $order) {
	if($order["endTime"] == null || $order["endTime"] == "") {
		$values = [
			"endTime"=>jmktime(),
		];
		$db->update("orders", ["id"=>$order["id"]], $values);
	}
}

$values = [
	"playID"=>$play["id"],
	"startTime"=>jmktime(),
	"planID"=>$plan["id"],
	"planDaste"=>$_POST["planDasteIndex"],
	"planIndexID"=>$_POST["planTabID"],
	"planPrice"=>$plan["price".$_POST["planDasteIndex"]],
];
$db->insert("orders", $values);

print "سفارش ثبت شد.";
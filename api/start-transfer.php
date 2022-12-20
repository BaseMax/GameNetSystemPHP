<?php
require "../_core.php";

// planID: planID,
// planIndex: planIndex,
// planTabID: planTabID,
// planFamily: planFamily,

// planDasteName: planDasteName,
// planDasteIndex: planDasteIndex+1,
// toPlanID: toPlanID,
// toPlanIndex: toPlanIndex,

// print_r($_POST);

// from:
// [planID] => 2
// [planIndex] => 10
// [planTabID] => 2


$clauses = [
    "planID"=>$_POST["toPlanID"],
    "planIndexID"=>$_POST["toPlanIndex"],
    "status"=>1,
];
// print_r($clauses);
$last_active_order = $db->select("orders", $clauses, "ORDER BY `id` DESC");
// print_r($last_active_order);

if($last_active_order != [] && $last_active_order != null) {
	print "امکان انتقال به این جایگاه وجود ندارد مشغول است!";
	exit();
}
else {
}

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
//print_r($last_order);

$clauses = [
	"id"=>$playID,
];
$play = $db->select("plays", $clauses);

// $clauses = [
// 	"family"=>$_POST["planFamily"],
// 	"name".$_POST["planDasteIndex"]=>$_POST["planDasteName"],
// ];
// $plan = $db->select("plans", $clauses, "", "id, price".$_POST["planDasteIndex"]);
// print_r($plan);

$clauses = [
	"id"=>$_POST["toPlanID"],
	// "family"=>$_POST["planFamily"],
	// "name".$_POST["planDasteIndex"]=>$_POST["planDasteName"],
];
$newPlan = $db->select("plans", $clauses, "", "id, price".$_POST["planDasteIndex"]);
// print_r($newPlan);

$clauses = [
	"playID"=>$play["id"],
];
$orders = $db->selects("orders", $clauses);
foreach($orders as $order) {
	if(
	    ($order["timer"] == 0 and ($order["endTime"] == null || $order["endTime"] == ""))
	) {
		$values = [
			"endTime"=>mytime(),
			"status"=>0,
		];
		$db->update("orders", ["id"=>$order["id"]], $values);
	}

	$db->update("orders", ["playID"=>$order["playID"]], [
		"status"=>0,
	]);
}


$values = [
	"playID"=>$play["id"],
	"startTime"=>mytime(),

	"planID"=>$newPlan["id"],
	"planIndexID"=>$_POST["toPlanIndex"],
	"planDaste"=>$_POST["planDasteIndex"],

	"planPrice"=>$newPlan["price".$_POST["planDasteIndex"]],
];
// print_r($values);
$db->insert("orders", $values);

print "با موفقیت منتقل شد.";

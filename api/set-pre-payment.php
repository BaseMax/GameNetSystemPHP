<?php
require "../_core.php";

// print_r($_POST);

// price: field.value,
// planID: planID,
// planIndex: planIndex,
// planFamily: planFamily,

// price: field.value,
// planID: planID,
// planIndex: planIndex,
// planFamily: planFamily,


$sql = "SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." ORDER BY `id` DESC;";
$last_order = $db->selectRaw($sql);
// $last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_POST["planID"]." AND `planIndexID` = ".$_POST["planTabID"]." AND ((`timer` = 0 AND `endTime` IS NULL) or (`timer` = 1)) AND `status` = 0 NULL ORDER BY `id` DESC;");
// print $sql."\n";
if($last_order == null || $last_order == []) {
    print "خطا!";
    exit();
}
else {
	// $playID = 1;
	$playID = $last_order["playID"];

	// print_r($last_order);

	$clauses = [
		"id"=>$playID,
	];
	$play = $db->select("plays", $clauses);
    
    if(isset($play["id"])) {
    	// $_POST["playID"] = 1;
    	$clauses = [
    		"id"=>$play["id"],
    	];
    	$values = [
    		"prePayment"=>$_POST["price"],
    	];
    	$db->update("plays", $clauses, $values);
    
    	// print_r($clauses);
    	// print_r($values);
    }
    else {
        print "خطا!";
        exit();
    }
}

print "پیش پرداخت ثبت شد.";

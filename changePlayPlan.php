<?php
require "_core.php";

$plans = $db->selects("plans");

if(!isset($_GET["id"])) {
	exit("error: no id!");
}
$play = $db->select("plays", ["id"=>$_GET["id"]]);
if($play == null || $play == []) {
	exit("error: cannot find this play!");
}
$playID = $play["id"];

// $orders = $db->selects("orders", ["playID"=>$playID]);
$orders = $db->selectsRaw("SELECT * FROM ". $db->db .".`orders` WHERE `playID` = $playID AND `endTime` IS NULL");
if($orders == null || $orders == []) {
	exit("هیچ سفارشی وجود ندارد که تمام نشده باشد!");
}

if(isset($_POST["submit"])) {
	// print_r($orders);
	$planID = $_POST["plan"];

	foreach($orders as $order) {
		$values = [
			"endTime"=>jmktime(),
		];
		$db->update("orders", ["id"=>$order["id"]], $values);
	}

	$values = [
		"playID"=>$playID,
		"startTime"=>jmktime(),
		"planID"=>$planID,
	];
	$db->insert("orders", $values);
	print "ثبت شد.";
	exit();
}
?>
<form action="" method="POST">
	<select name="plan">
		<?php foreach($plans as $plan) { ?>
		<option value="<?= $plan["id"]?>">
			<?= $plan["family"] ?> - <?= $plan["name"] ?>
		</option>
		<?php } ?>
	</select>
	<button name="submit">تغییر </button>
</form>

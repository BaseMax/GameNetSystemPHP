<?php
require "_core.php";

if(!isset($_GET["id"])) {
	exit("error: no id!");
}
$play = $db->select("plays", ["id"=>$_GET["id"]]);
if($play == null || $play == []) {
	exit("error: cannot find this play!");
}
$playID = $play["id"];

$sumPrice = 0;
$orders = $db->selects("orders", ["playID"=>$playID]);

foreach($orders as $i=>$order) {
	if($order["endTime"] == null || $order["endTime"] == "") {
		$endTime = jmktime();
		$db->update("orders", ["id"=>$order["id"]], ["endTime"=>$endTime]);
		$order["endTime"] = $endTime;
	}
	$timeDiff = $order["endTime"] - $order["startTime"];
	$timeMin = ceil($timeDiff / 60);
	$price = $timeMin * $order["planPrice"];
	$sumPrice+= $price;
	$orders[$i]["price"] = $price;
	$orders[$i]["timeDiff"] = $timeDiff;
	$orders[$i]["timeMin"] = $timeMin;
}

$clauses = [
	"id"=>$playID
];
$values = [
	"pending"=>0,
	"price"=>$sumPrice, //rand(500,80000),
];

$db->update("plays", $clauses, $values);

// header("Location: /");
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">

مشخصه مشتری/سیستم: <?= $play["name"] ?>
<br>

<?php foreach($orders as $order) { ?>
<table width="100%" dir="rtl" border="1">
	<tr>
		<td>شروع</td>
		<td><?= jdate('Y/m/d H:i:s', $order["startTime"]) ?></td>
	</tr>
	<tr>
		<td>پایان</td>
		<td><?= jdate('Y/m/d H:i:s', $order["endTime"]) ?></td>
	</tr>
	<tr>
		<td>قیمت پلن</td>
		<td><?= $order["planPrice"] ?> تومان</td>
	</tr>
	<tr>
		<td>زمان به دقیقه</td>
		<td><?= $order["timeMin"] ?> دقیقه</td>
	</tr>
	<tr>
		<td>قیمت</td>
		<td><?= $order["price"] ?> تومان</td>
	</tr>
</table>
<?php } ?>

<br>

<b>
قیمت کل:
</b>
<?= $sumPrice ?> تومان
<br>


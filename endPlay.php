<?php
require "_core.php";

if(!isset($_GET["i"], $_GET["j"], $_GET["id"])) {
	header("Location: index.php");
	// exit("error: no required params!");
	exit();
}

// endPlay.php?i=11&j=3&id=2
// $clauses = [
// 	"planID"=>$_GET["id"],
// 	"planIndexID"=>$_GET["j"],
// ];
// $last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_GET["id"]. " AND `planIndexID` = ".$_GET["j"]." AND `endTime` IS NULL ORDER BY `id` DESC");
$last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$_GET["id"]. " AND `planIndexID` = ".$_GET["j"]." ORDER BY `id` DESC");
if($last_order == null || $last_order == []) {
	header("Location: index.php");
	// exit("Not found!");
	exit();
}
else {
	$play = $db->select("plays", ["id"=>$last_order["playID"]]);
	if($play == null || $play == []) {
		exit("error: cannot find this play!");
	}
	$playID = $play["id"];
}

// print_r($play);
// print "<hr>";
// print $playID."\n";

$sumPrice = 0;
$orders = $db->selects("orders", ["playID"=>$playID]);

// print_r($orders);
foreach($orders as $i=>$order) {
	if($order["endTime"] == null || $order["endTime"] == "") {
		$endTime = jmktime();
		// $db->update("orders", ["id"=>$order["id"]], ["endTime"=>$endTime]);
		$orders[$i]["endTime"] = $endTime;
		$orders[$i]["endTimeNow"] = true;
	}
	$timeDiff = $orders[$i]["endTime"] - $order["startTime"];
	$timeMin = ceil($timeDiff / 60);
	$price = $timeMin * $orders[$i]["planPrice"];
	$sumPrice+= $price;
	$orders[$i]["price"] = $price;
	$orders[$i]["timeDiff"] = $timeDiff;
	$orders[$i]["timeMin"] = $timeMin;
}

// print_r($play);
$foods = $db->selects("orders_food", ["playID"=>$play["id"]]);
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">

مشخصه مشتری/سیستم
<br>
<?php
// print_r($orders);
?>
<?php foreach($orders as $order) { ?>
<table width="100%" dir="rtl" border="1">
	<tr>
		<td width="100">سیستم</td>
		<td>
			<?php
			if($order["planID"] == 1) {
				$order["planIDName"] = "معمولی";
				$order["planIndexIDName"] = $order["planIndexID"];
			}
			else if($order["planID"] == 2) {
				$order["planIDName"] = "آنلاین";
				$order["planIndexIDName"] = 8 + $order["planIndexID"];
			}
			else if($order["planID"] == 3) {
				$order["planIDName"] = "VIP";
				$order["planIndexIDName"] = 11 + $order["planIndexID"];
			}
			?>
			سیستم <?= $order["planIndexIDName"] ?> <?= $order["planIDName"]?> (<?= $order["planDaste"] ?> دسته)
			<!-- <br> -->
			<a style="text-decoration: none;float:left; width: auto;padding: 2px;border-radius: 4px;background-color: green;color: white;" href="deleteOrder.php?i=<?= $_GET["i"] ?>&j=<?= $_GET["j"] ?>&id=<?= $order["id"] ?>&playId=<?= $_GET["id"] ?>">حذف</a>
		</td>
	</tr>
	<tr>
		<td width="100">شروع</td>
		<td><?= jdate('Y/m/d - H:i:s', $order["startTime"]) ?></td>
	</tr>
	<tr>
		<td width="100">پایان</td>
		<?php
		// var_dump($order["endTime"]);
		?>
		<td>
			<?= jdate('Y/m/d - H:i:s', $order["endTime"]) ?>
			<?php
			if(isset($order["endTimeNow"])) { ?>
				(تا کنون)
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td width="100">زمان به دقیقه</td>
		<td><?= $order["timeMin"] ?> دقیقه</td>
	</tr>
	<tr>
		<td width="100">قیمت پلن</td>
		<td><?= $order["planPrice"] ?> تومان</td>
	</tr>
	<tr>
		<td width="100">قیمت</td>
		<td><?= $order["price"] ?> تومان</td>
	</tr>
</table>
<br>
<?php } ?>

<hr>
<?php
$sumFood = 0;
?>
<?php if(is_array($foods) and count($foods) > 0) { ?>
<table border="1" width="100%">
	<tr>
		<td>نام</td>
		<td>تعداد</td>
		<td>قیمت فی</td>
		<td>قیمت</td>
	</tr>
	<?php foreach($foods as $food) { ?>
		<?php
		$_food = $db->select("foods", ["id"=>$food["foodID"]]);
		// print_r($food);
		// print_r($_food);
		$food["count"] = (int) $food["count"];
		$food["price"] = (int) $food["price"];
		$food["priceAll"] = (int) ($food["count"] * $food["price"]);
		$sumFood += $food["priceAll"];
		?>
		<tr>
			<td><?= $_food["name"];?></td>
			<td><?= $food["count"];?></td>
			<td><?= number_format($food["price"]) ?></td>
			<td><?= number_format($food["priceAll"]) ?></td>
		</tr>
	<?php } ?>
</table>
<?php } else { ?>
	<center>
		هیچ خریدی از بوفه انجام نشده است!
	</center>
<?php } ?>

<br>

<b>
قیمت سیستم ها:
</b>
<?= number_format($sumPrice) ?> تومان
<br>

<b>
قیمت بوفه:
</b>
<?= number_format($sumFood) ?> تومان
<br>

<b>
قیمت سیستم و بوفه:
</b>
<?= number_format($sumPrice + $sumFood) ?> تومان
<br>

<b>
قیمت پیش پرداخت:
</b>
<?= number_format($play["prePayment"]) ?> تومان
<br>

<span style="background:yellow;padding:4px;">
<b>
قیمت نهایی:
</b>
<?= number_format($sumPrice + $sumFood - $play["prePayment"]) ?> تومان
</span>

<br>
<br>

<form action="" method="POST">
	<button name="submit">تمام کردن سفارش و حذف</button>
</form>

<?php

if(isset($_POST["submit"])) {
	// print_r($_POST);
	foreach($orders as $i=>$order) {
		$db->delete("orders", ["id"=>$order["id"]]);
	}

	$clauses = [
		"id"=>$playID
	];
	$values = [
		"pending"=>0,
		"price"=>$sumPrice + $sumFood, //rand(500,80000),
	];

	$db->update("plays", $clauses, $values);

	$db->delete("orders", ["playID"=>$play["id"]]);
	$db->delete("orders_food", ["playID"=>$play["id"]]);
	$db->delete("plays", ["id"=>$play["id"]]);

	header("Location: index.php");	
}
?>
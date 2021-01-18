<?php
require "_core.php";

if(isset($_POST["submit"]) and isset($_POST["type"])) {
	if($_POST["type"] === "plan") {
		$items = [];
		foreach($_POST["id"] as $i=>$value) {
			$items[$i]["id"] = $value;
		}
		foreach($_POST["family"] as $i=>$value) {
			$items[$i]["family"] = $value;
		}
		foreach($_POST["name"] as $i=>$value) {
			$items[$i]["name"] = $value;
		}
		foreach($_POST["price"] as $i=>$value) {
			$items[$i]["price"] = $value;
		}
		// print_r($items);
		foreach($items as $item) {
			$db->update("plans", ["id"=>$item["id"]], $item);
			// $db->insert("plans", $item);
		}
	}
	if($_POST["type"] === "newPlan") {
		
	}
	if($_POST["type"] === "new") {
		$price = $db->select("plans", ["id"=>$_POST["plan"]]);
		if(isset($price["price"])) {
			$values = [
				"name"=>$_POST["name"],
				"pending"=>1,
			];
			$playID = $db->insert("plays", $values);
			$values = [
				"playID"=>$playID,
				"startTime"=>jmktime(),
				"planID"=>$_POST["plan"],
				"planPrice"=>$price["price"],
			];
			// print_r($values);
			$db->insert("orders", $values);
		}
	}
}
$plans = $db->selects("plans");

// $plays = $db->selects("plays");
$activePlays = $db->selects("plays", ["pending"=>1]);
$oldPlays = $db->selects("plays", ["pending"=>0]);
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">

<center>
<a target="_blank" href="setting.php">بخش تنظیمات</a>
</center>

<hr>

<center>
	<h1>درج مشتری  حضوری</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نام مشتری/سیستم</td>
			<td>
				<input type="text" name="name">
			</td>
		</tr>
		<tr>
			<td>پلن</td>
			<td>
				<select name="plan">
					<?php foreach($plans as $plan) { ?>
					<option value="<?= $plan["id"]?>">
						<?= $plan["family"] ?> - <?= $plan["name"] ?>
					</option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>
	<input type="hidden" name="type" value="new">
	<button name="submit">شروع زمان</button>
</form>


<center>
	<h1>مشتریان فعلی</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نام</td>
			<td>پلن</td>
			<td>ساعت</td>
			<td>زمان به دقیقه</td>
			<td>مدیریت</td>
		</tr>
		<?php foreach($activePlays as $play) { ?>
		<?php
		$orders = $db->selects("orders", ["playID"=>$play["id"]]);
		?>
		<tr>
			<td>
				<?= $play["name"] ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?php
					$plan = $db->select("plans", ["id"=>$order["planID"]]);
					?>
					<?= $plan["family"] ?> - <?= $plan["name"] ?>
					<br>
				<?php } ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?= jdate('Y/m/d H:i:s', $order["startTime"]) ?>
					&nbsp;
					-
					&nbsp;
					<?= $order["endTime"] == null ? "در حال بازی" : jdate('Y/m/d H:i:s', $order["endTime"]) ?>
					<br>
				<?php } ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?php
					$noYet = false;
					if($order["endTime"] == "" || $order["endTime"] == null) {
						$order["endTime"] = jmktime();
						$noYet = true;
					}
					$timeDiff = $order["endTime"] - $order["startTime"];
					$timeMin = ceil($timeDiff / 60);
					print $timeMin;
					print ' دقیقه';
					if($noYet === true) {
						print " (تا کنون)";
					}
					// $order["endTime"] - $order["startTime"];
					?>
					<br>
				<?php } ?>
			</td>
			<td>
				<!-- <a href="?type=endPlan&id=<?= $play["id"] ?>">تمام کردن بازی</a> -->
				<a class="button" href="endPlay.php?id=<?= $play["id"] ?>">تمام کردن بازی</a>
				&nbsp;&nbsp;
				<!-- <a href="?type=changePlan&id=<?= $plan["id"]?>">تغییر پلن</a> -->
				<a class="button" href="changePlayPlan.php?id=<?= $play["id"]?>">تغییر پلن</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="plan">
	<button name="submit">ذخیره</button>
</form>


<center>
	<h1>مشتریان قبلی</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نام</td>
			<td>پلن</td>
			<td>ساعت</td>
			<td>زمان به دقیقه</td>
			<td>قیمت</td>
		</tr>
		<?php foreach($oldPlays as $play) { ?>
		<?php
		$orders = $db->selects("orders", ["playID"=>$play["id"]]);
		?>
		<tr>
			<td>
				<?= $play["name"] ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?php
					$plan = $db->select("plans", ["id"=>$order["planID"]]);
					?>
					<?= $plan["family"] ?> - <?= $plan["name"] ?>
				<?php } ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?= jdate('Y/m/d H:i:s', $order["startTime"]) ?>
					&nbsp;
					-
					&nbsp;
					<?= $order["endTime"] == null ? "در حال بازی" : jdate('Y/m/d H:i:s', $order["endTime"]) ?>
					<br>
				<?php } ?>
			</td>
			<td>
				<?php foreach($orders as $order) { ?>
					<?php
					$timeDiff = $order["endTime"] - $order["startTime"];
					$timeMin = ceil($timeDiff / 60);
					print $timeMin;
					// $order["endTime"] - $order["startTime"];
					?> دقیقه
					<br>
				<?php } ?>
			</td>
			<td>
				<?= $play["price"]?> تومان
			</td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="plan">
	<button name="submit">ذخیره</button>
</form>

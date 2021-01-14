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
				<!-- <a href="?type=endPlan&id=<?= $play["id"] ?>">تمام کردن بازی</a> -->
				<a href="endPlay.php?id=<?= $play["id"] ?>">تمام کردن بازی</a>
				&nbsp;&nbsp;
				<!-- <a href="?type=changePlan&id=<?= $plan["id"]?>">تغییر پلن</a> -->
				<a href="changePlayPlan.php?id=<?= $play["id"]?>">تغییر پلن</a>
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
				<?= $play["price"]?> تومان
			</td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="plan">
	<button name="submit">ذخیره</button>
</form>

<center>
	<h1>ویرایش پلن ها</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نوع</td>
			<td>اسم پلن</td>
			<td>قیمت دقیقه</td>
		</tr>
		<?php foreach($plans as $plan) { ?>
		<tr>
			<td>
				<input type="hidden" name="id[]" value="<?= $plan["id"]?>">
				<input type="text" name="family[]" value="<?= $plan["family"]?>">
			</td>
			<td>
				<input type="text" name="name[]" value="<?= $plan["name"]?>">
			</td>
			<td>
				<input type="number" name="price[]" value="<?= $plan["price"]?>">
			</td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="plan">
	<button name="submit">ذخیره</button>
</form>

<center>
	<h1>درج پلن جدید</h1>
</center>
<form>
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نوع</td>
			<td>
				<input type="text" name="family">
			</td>
		</tr>
		<tr>
			<td>نام پلن</td>
			<td>
				<input type="text" name="name">
			</td>
		</tr>
		<tr>
			<td>قیمت دقیقه ای</td>
			<td>
				<input type="number" name="price">
			</td>
		</tr>
	</table>
	<input type="hidden" name="type" value="newPlan">
	<button name="submit">درج پلن جدید</button>
</form>

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
		foreach($_POST["name1"] as $i=>$value) {
			$items[$i]["name1"] = $value;
		}
		foreach($_POST["name2"] as $i=>$value) {
			$items[$i]["name2"] = $value;
		}
		foreach($_POST["name3"] as $i=>$value) {
			$items[$i]["name3"] = $value;
		}
		foreach($_POST["name4"] as $i=>$value) {
			$items[$i]["name4"] = $value;
		}
		foreach($_POST["price1"] as $i=>$value) {
			$items[$i]["price1"] = $value;
		}
		foreach($_POST["price2"] as $i=>$value) {
			$items[$i]["price2"] = $value;
		}
		foreach($_POST["price3"] as $i=>$value) {
			$items[$i]["price3"] = $value;
		}
		foreach($_POST["price4"] as $i=>$value) {
			$items[$i]["price4"] = $value;
		}
		foreach($_POST["count"] as $i=>$value) {
			$items[$i]["count"] = $value;
		}
		// print_r($items);
		foreach($items as $item) {
			$db->update("plans", ["id"=>$item["id"]], $item);
			// $db->insert("plans", $item);
		}
	}
	if($_POST["type"] === "newPlan") {
		$values = [
			"family"=>$_POST["family"],

			"name1"=>$_POST["name1"],
			"name2"=>$_POST["name2"],
			"name3"=>$_POST["name3"],
			"name4"=>$_POST["name4"],

			"count"=>$_POST["count"],

			"price1"=>$_POST["price1"],
			"price2"=>$_POST["price2"],
			"price3"=>$_POST["price3"],
			"price4"=>$_POST["price4"],
		];
		$db->insert("plans", $values);
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

<a href="index.php">
    برگشت به اتاق فرمان
</a>
<br>


<center>
	<h1>ویرایش پلن ها</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نوع</td>
			<td>اسم پلن</td>
			<td>قیمت دقیقه</td>
			<td>تعداد</td>
			<!-- <td>مدیریت</td> -->
		</tr>
		<?php foreach($plans as $plan) { ?>
		<tr>
			<td>
				<input type="hidden" name="id[]" value="<?= $plan["id"]?>">
				<input type="text" name="family[]" value="<?= $plan["family"]?>">
			</td>
			<td>
				<input type="text" name="name1[]" value="<?= $plan["name1"]?>">
				<br>
				<input type="text" name="name2[]" value="<?= $plan["name2"]?>">
				<br>
				<input type="text" name="name3[]" value="<?= $plan["name3"]?>">
				<br>
				<input type="text" name="name4[]" value="<?= $plan["name4"]?>">
			</td>
			<td>
				<input type="number" name="price1[]" value="<?= $plan["price1"]?>"> تومان
				<br>
				<input type="number" name="price2[]" value="<?= $plan["price2"]?>"> تومان
				<br>
				<input type="number" name="price3[]" value="<?= $plan["price3"]?>"> تومان
				<br>
				<input type="number" name="price4[]" value="<?= $plan["price4"]?>"> تومان
			</td>
			<td>
				<input type="number" name="count[]" value="<?= $plan["count"]?>">
			</td>
			<!-- <td> -->
				<!-- <a href="?type=deletePlan&id=<?= $plan["id"] ?>">حذف کردن این پلن</a> -->
			<!-- </td> -->
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="plan">
	<button name="submit">ذخیره</button>
</form>

<center>
	<h1>درج پلن جدید</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نوع</td>
			<td>
				<input type="text" name="family" required="">
			</td>
		</tr>
		<tr>
			<td>نام پلن</td>
			<td>
				<input type="text" name="name1" required="">
				<br>
				<input type="text" name="name2" required="">
				<br>
				<input type="text" name="name3" required="">
				<br>
				<input type="text" name="name4" required="">
				<br>
			</td>
		</tr>
		<tr>
			<td>قیمت دقیقه ای </td>
			<td>
				<input type="number" name="price1" required=""> تومان
				<br>
				<input type="number" name="price2" required=""> تومان
				<br>
				<input type="number" name="price3" required=""> تومان
				<br>
				<input type="number" name="price4" required=""> تومان
			</td>
		</tr>
		<tr>
			<td>تعداد</td>
			<td>
				<input type="number" name="count" value="1" required="">
			</td>
		</tr>
	</table>
	<input type="hidden" name="type" value="newPlan">
	<button name="submit">درج پلن جدید</button>
</form>

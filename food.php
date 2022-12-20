<?php
require "_core.php";

if(isset($_POST["submit"]) and isset($_POST["type"])) {
	if($_POST["type"] === "food") {
		$items = [];
		foreach($_POST["id"] as $i=>$value) {
			$items[$i]["id"] = $value;
		}
		foreach($_POST["name"] as $i=>$value) {
			$items[$i]["name"] = $value;
		}
		foreach($_POST["buy"] as $i=>$value) {
			$items[$i]["buy"] = $value;
		}
		foreach($_POST["sale"] as $i=>$value) {
			$items[$i]["sale"] = $value;
		}
		// print_r($items);
		foreach($items as $item) {
			$db->update("foods", ["id"=>$item["id"]], $item);
			// $db->insert("plans", $item);
		}
	}
	if($_POST["type"] === "newFood") {
		$values = [
			"name"=>$_POST["name"],

			"buy"=>$_POST["buy"],
			"sale"=>$_POST["sale"],

			// "count"=>$_POST["count"],
		];
		$db->insert("foods", $values);
	}
}
$foods = $db->selects("foods");
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">


<a href="index.php">
    برگشت به اتاق فرمان
</a>
<br>

<center>
	<h1>ویرایش انبار</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>اسم</td>
			<td>قیمت خرید</td>
			<td>قیمت فروش</td>
			<!-- <td>تعداد</td> -->
			<!-- <td>مدیریت</td> -->
		</tr>
		<?php foreach($foods as $food) { ?>
		<tr>
			<td>
				<input type="hidden" name="id[]" value="<?= $food["id"]?>">
				<input type="text" name="name[]" value="<?= $food["name"]?>">
			</td>
			<td>
				<input type="text" name="buy[]" value="<?= $food["buy"]?>">
			</td>
			<td>
				<input type="number" name="sale[]" value="<?= $food["sale"]?>"> تومان
			</td>
			<!-- <td> -->
				<!-- <a href="?type=deletePlan&id=<?= $food["id"] ?>">حذف کردن این پلن</a> -->
			<!-- </td> -->
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="type" value="food">
	<button name="submit">ذخیره</button>
</form>

<center>
	<h1>درج جنس جدید</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>اسم</td>
			<td>
				<input type="text" name="name" required="">
			</td>
		</tr>
		<tr>
			<td>قیمت خرید </td>
			<td>
				<input type="number" name="buy" required=""> تومان
			</td>
		</tr>
		<tr>
			<td>قیمت فروش</td>
			<td>
				<input type="number" name="sale" required=""> تومان
			</td>
		</tr>
	</table>
	<input type="hidden" name="type" value="newFood">
	<button name="submit">درج</button>
</form>

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
	<h1>ویرایش پلن ها</h1>
</center>
<form action="" method="POST">
	<table width="100%" dir="rtl" border="1">
		<tr>
			<td>نوع</td>
			<td>اسم پلن</td>
			<td>قیمت دقیقه</td>
			<!-- <td>مدیریت</td> -->
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

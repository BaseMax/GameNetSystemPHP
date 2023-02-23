<!-- <meta http-equiv="refresh" content="15; url="> -->
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
		foreach($items as $item) {
			$db->update("plans", ["id"=>$item["id"]], $item);
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
				"startTime"=>mytime(),
				"planID"=>$_POST["plan"],
				"planPrice"=>$price["price"],
			];
			$db->insert("orders", $values);
		}
	}
}
$plans = $db->selects("plans");

$foods = $db->selects("foods");
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css?r=<?=rand()?>">
<link rel="stylesheet" type="text/css" href="sweetalert2.min.css?r=<?=rand()?>">


<script type="text/javascript" src="script.js?r=<?=rand()?>"></script>
<!--<script type="text/javascript" src="script.js"></script>-->

<script type="text/javascript" src="sweetalert2.min.js"></script>
<!--<script type="text/javascript" src="sweetalert2@10.js"></script>-->
<!--<script type="text/javascript" src="polyfill.js"></script>-->

<div class="tab">
	<button class="tablinks active" onclick="openCity(event, 'new-customer')" id="tab-new-customer">اتاق فرمان</button>
	<?php $i=1; ?>
	<?php foreach($plans as $plan) { ?>
		<?php for($j=1;$j<=$plan["count"]; $j++) { ?>
			<button id="tab-system-<?=$i ?>" class="tablinks" onclick="openCity(event, 'system-<?= $i ?>')"><?= $i ?> - <?= $plan["family"]?></button>
			<?php $i++ ?>
		<?php } ?>
	<?php } ?>
</div>

<?php $i=1; ?>
<?php foreach($plans as $plan) { ?>
	<?php for($j=1;$j<=$plan["count"]; $j++) { ?>
		<?php
$last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$plan["id"]." AND `planIndexID` = ".$j." AND `endTime` IS NULL ORDER BY `id` DESC;");
if($last_order == null || $last_order == []) {
	$play = [];
	$play["prePayment"] = 0;
}
else {
	$playID = $last_order["playID"];
	$clauses = [
		"id"=>$playID,
	];
	$play = $db->select("plays", $clauses);
}
		?>
		<div class="tabcontent tabcontent-system" style="display:none;" id="system-<?=$i?>">
			<center>
				<h1>سیستم  <?= $i ?> - <?= $plan["family"] ?></h1>
			</center>
			<br>
			<div class="left-side">
				<select name="food">
					<?php foreach($foods as $food) { ?>
						<option value="<?= $food["id"]?>"><?= $food["name"]?></option>
					<?php } ?>
				</select>
				<select name="food_count">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<button onclick="addFood(this, <?= $i ?>, <?= $j ?>, <?= $plan["id"]?>);">اضافه کردن به بوفه</button>
				<br>
				<select name="plan">
					<?php $m = 1 ?>
					<?php foreach($plans as $_plan) { ?>
						<?php for($k=1;$k<=$_plan["count"]; $k++) { ?>
							<?php if($i != $m) { ?>
								<option value="<?= $_plan["id"]?>_<?= $k?>"><?= $m ?> - <?= $_plan["family"] ?></option>
							<?php } ?>
							<?php $m++ ?>
						<?php } ?>
					<?php } ?>
				</select>
				<select name="daste">
					<?php for($k=1;$k<=4; $k++) { ?>
						<option><?= $plan["name".$k]?></option>
					<?php } ?>
				</select>
				<button onclick="startTransfer(this, <?= $i ?>, <?= $j ?>, <?= $plan["id"] ?>, '<?= $plan["family"]?>');">انتقال</button>
			</div>
			<div class="right-side">
				<select>
					<?php for($k=1;$k<=4; $k++) { ?>
						<option><?= $plan["name".$k]?></option>
					<?php } ?>
				</select>
				<button onclick="startPlaying(this, <?= $i ?>, <?= $j ?>, <?= $plan["id"]?>, '<?= $plan["family"]?>');">شروع / تغییر دسته</button>
			</div>
			<div class="clear"></div>
			<hr>
			<table width="100%" dir="rtl" border="1">
			    <thead>
    				<tr>
    					<td>تعداد دسته</td>
    					<td>ساعت</td>
    					<td>زمان به دقیقه</td>
    					<td>قیمت</td>
    					<td>مدیریت</td>
    				</tr>
				</thead>
				<tbody class="table_content_rows"></tbody>
			</table>
			<br>
			<div class="clear"></div>
			<div class="right-side">
				قیمت کل: <label class="total-price">0</label> تومان
				<br>
				مبلغ قابل پرداخت: <label style="background:yellow;" class="total-price-to-payment">0</label> تومان
				<br>
				<a class="button" href="endPlay.php?i=<?= $i ?>&j=<?=$j?>&id=<?=$plan["id"]?>">اتمام بازی</a>
			</div>
			<div class="left-side">
				مبلغ پیش پرداخت: 
				<input type="number" name="pre-payment" required="" value="<?= $play["prePayment"] ?>">
				تومان
				<button onclick="setPrePayment(this, <?= $plan["id"] ?>, <?= $j ?>, <?= $plan["id"]?>, '<?= $plan["family"]?>');">ثبت پیش پرداخت</button>
			</div>
			<div class="clear"></div>
		</div>
		<?php $i++ ?>
	<?php } ?>
<?php } ?>

<div class="tabcontent" id="new-customer">
    <center>
        <a href="setting.php">تنظیمات</a>
        &nbsp;&nbsp;
        <a href="report.php">حسابداری</a>
        &nbsp;&nbsp;
        <a href="food.php">بخش بوفه</a>
    </center>
    <hr>
    <div id="table-list"></div>
</div>

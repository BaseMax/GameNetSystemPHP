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

$foods = $db->selects("foods");
// $plays = $db->selects("plays");
// $activePlays = $db->selects("plays", ["pending"=>1]);
// $oldPlays = $db->selects("plays", ["pending"=>0]);
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="script.js"></script>

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
	// $values=[
	// ];
	// $playID = $db->insert("plays", $values);
	$play = [];
	$play["prePayment"] = 0;
}
else {
	// $playID = 1;
	$playID = $last_order["playID"];
	$clauses = [
		"id"=>$playID,
	];
	$play = $db->select("plays", $clauses);
}
// print_r($last_order);




		// $play = $db->select("plays", ["id"=>1]);
		// if(!isset($play["prePayment"])) {
		// 	$play["prePayment"] = 0;
		// }
		?>
		<div class="tabcontent" style="display:none;" id="system-<?=$i?>">
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
				<!--
				<select name="plan">
					<option>یک دسته</option>
					<option>دو دسته</option>
					<option>سه دسته</option>
					<option>چهار دسته</option>
				</select>
				<button>تغییر پلن</button>
				<br>
				-->
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
				<tr>
					<td>تعداد دسته</td>
					<td>ساعت</td>
					<td>زمان به دقیقه</td>
					<td>قیمت</td>
					<td>مدیریت</td>
				</tr>
				<?php
				$clauses = [
					"planID"=>$plan["id"],
					"planIndexID"=>$j,
					"status"=>1,
				];
				// print_r($clauses);
				$price=0;
				$orders = $db->selects("orders", $clauses);
				foreach($orders as $order) {
				?>
				<tr>
					<td>
						<?= $order["planDaste"] ?>
					</td>
					<td>
						<?= jdate('Y/m/d H:i:s', $order["startTime"]) ?>
						&nbsp;
						-
						&nbsp;
						<?= $order["endTime"] == null ? "در حال بازی" : jdate('Y/m/d H:i:s', $order["endTime"]) ?>
						<br>
					</td>
					<td>
						<?php
						$noYet = false;
						if($order["endTime"] == "" || $order["endTime"] == null) {
							$order["_endTime"] = jmktime();
							$noYet = true;
						}
						else {
							$order["_endTime"] = $order["endTime"];
						}
						$timeDiff = $order["_endTime"] - $order["startTime"];
						$timeMin = round($timeDiff / 60);
						print $timeMin;
						print ' دقیقه';
						if($noYet === true) {
							print " (تا کنون)";
						}
						// $order["endTime"] - $order["startTime"];
						?>
						<button onclick="openChangeTime(this, <?= $order["id"] ?>);">تغییر</button>
						<br>
						<div id="edit-manualy" style="display:none;">
							زمان به دقیقه: <input name="time" type="number" value="<?= $timeMin ?>">
							<br>
							تعداد دسته:
							<!-- <input name="daste" type="number" value="<?= $order["planDaste"] ?>"> -->
							<select name="daste">
								<?php for($n=1;$n<=4;$n++) { ?>
								<option<?= ($n == $order["planDaste"]) ? " selected" : "" ?> value="<?= $n ?>"><?= $n ?> دسته</option>
								<?php } ?>
							</select>
							<button onclick="changeTime(this, <?= $order["id"] ?>);">ثبت زمان</button>
						</div>
					</td>
					<td>
						<?php
						$p = $timeMin * $order["planPrice"];
						$price += $p;
						print number_format($p);
						?>
						تومان
					</td>
					<td>
						<?php if($order["endTime"] == null || $order["endTime"] == "") { ?>
						<a class="button" onclick="stopOrder(<?= $order["id"]?>)">غیر فعال </a>
						<?php } ?>
						<!-- &nbsp; -->
						<!-- <a class="button" href="endPlay.php?id=<?= $play["id"] ?>">حذف</a> -->
					</td>
				</tr>
				<?php } ?>
			</table>
			<br>
			<div class="clear"></div>
			<div class="right-side">
				قیمت کل: <label class="total-price"><?= number_format($price);?></label> تومان
				<br>
				مبلغ قابل پرداخت: <label style="background:yellow;" class="total-price-to-payment"><?= number_format($price - $play["prePayment"]);?></label> تومان
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
	<a target="_blank" href="setting.php">بخش حسابداری</a>
	&nbsp;&nbsp;
	<a target="_blank" href="food.php">بخش بوفه</a>
	</center>
	<hr>
	<!-- onclick="openCity(event, 'new-customer')" id="defaultOpen" -->
	<?php $i=1; ?>
	<?php foreach($plans as $im=>$plan) { ?>
	<?php if($im == 2) { ?>
	<?php } else { ?>
	<div class="rows-<?= $plan["count"] ?>">
	<?php } ?>
		<?php
		for($j=1;$j<=$plan["count"]; $j++) {
		// for($j=$plan["count"]; $j>0; $j--) {
		?>
		<?php
		$clauses = [
			"planID"=>$im+1,
			"planIndexID"=>$j,
			"status"=>1,
		];
		// print_r($clauses);
		$last_active_order = $db->select("orders", $clauses, "ORDER BY `id` DESC");
		// print_r($last_active_order);
		$color = "gray";
		// if(isset($last_active_order["endTime"]) && $last_active_order["endTime"] != "" && $last_active_order["endTime"] != null) {

		// var_dump($last_active_order);
		if($last_active_order != [] && $last_active_order != null) {
			// if($last_active_order["endTime"] == "" or $last_active_order["endTime"] == null) {
				// print "1";
				$color = "red";
				$last_active_order["time_in_min"]=jmktime() - $last_active_order["startTime"];
				// print_r($last_active_order);
				$last_active_order["time_in_min"]=round($last_active_order["time_in_min"] / 60);
				$last_active_order["price"]=round($last_active_order["time_in_min"] * $last_active_order["planPrice"]);
				$last_active_order["daste"]=$last_active_order["planDaste"];
			// }
			// else {
			// 	// print "2";
			// 	$color = "green";
			// }
		}
		else {
			// print "3";
			$color = "green";
		}
		if(!isset($last_active_order["daste"])) {
			$last_active_order["time_in_min"] = "-";
			$last_active_order["price"]="-";
			$last_active_order["daste"]="-";
		}
		?>
		<div id="btn-system-<?= $i ?>" class="col <?= $color?>" onclick="openCity(event, 'system-<?= $i ?>')">
			<?= $i ?>
			<?= $plan["family"] ?>
			<hr>
			<!-- <br> -->
			<b>قیمت: </b>
			<br>
			<label>
				<?php
				$sumPrice = 0;
				if(isset($last_active_order["playID"])) {
					$orders = $db->selects("orders", ["playID"=>$last_active_order["playID"]]);
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
				}
				// print $last_active_order["price"];
				print $sumPrice;
				?>
			</label>
			<hr>
			<!-- <br> -->
			<b>زمان: </b>
			<br>
			<label>
				<?= $last_active_order["time_in_min"]?>
			</label>
			<hr>
			<!-- <br> -->
			<b>دسته: </b>
			<br>
			<label>
				<?= $last_active_order["daste"]?>
			</label>
		</div>
		<?php $i++; ?>
		<?php } ?>
	<?php if($im == 2) { ?>
	</div>
	<?php } else { ?>
	<?php } ?>
	<?php } ?>
</div>

<?php
exit();
?>
<center>
	<h1>مشتریان فعلی</h1>
</center>
<div class="tabs">
	<div class="tab-item">
		<h3>سیستم 1</h3>
		<content>
			c1
		</content>
	</div>
	<div class="tab-item">
		<h3>سیستم 1</h3>
		<content>
			c1
		</content>
	</div>
	<div class="tab-item">
		<h3>سیستم 1</h3>
		<content>
			c1
		</content>
	</div>
</div>
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
					$timeMin = round($timeDiff / 60);
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

<!--
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
					$timeMin = round($timeDiff / 60);
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
-->


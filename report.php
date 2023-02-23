<?php
require "_core.php";

$result1 = [];
$result2 = [];

$now_year = fa2en(jdate("Y"));

function reportGames(array $from, array $to) : array
{
    global $db;

    $sql = "SELECT orders.planID, orders.planIndexID, orders.planDaste, plans.family, orders.planPrice, plans.name1, plans.name2, plans.name3, plans.name4, plans.price1, plans.price2, plans.price3, plans.price4, orders.startTime, orders.endTime
        FROM `orders`
        INNER JOIN `plans` ON `plans`.`id` = `orders`.`planID`
        WHERE `orders`.`endTime` IS NOT NULL AND
            `orders`.`has_canceled` = 0 AND
            `orders`.`datetime`
            BETWEEN '".$from["year"]."-".$from["month"]."-".$from["day"]."' AND '".$to["year"]."-".$to["month"]."-".$to["day"]."'";
    // var_dump($sql);

    $rows = $db->selectsRaw($sql);
    foreach ($rows as $i => $order) {
        $timeDiff = $order["endTime"] - $order["startTime"];
        $timeMin = ceil($timeDiff / 60);
        $price = $timeMin * $order["planPrice"];

        if ($order["endTime"] === null) {
            $rows[$i]["total_price"] = null;
        } else {
            $rows[$i]["total_price"] = $price;
        }

        $rows[$i]["family_index"] = $order["planIndexID"] . "امی";
        $rows[$i]["family_daste"] = $order["name" . $order["planDaste"]];
    }

    return $rows;
}

function reportFoods(array $from, array $to) : array
{
    global $db;

    $sql = "SELECT foods.name, orders_food.price, orders_food.our_price, `orders_food`.count
        FROM `orders_food`
        INNER JOIN `foods` ON `orders_food`.`foodId` = `foods`.`id`
        WHERE `orders_food`.`datetime`
            BETWEEN '".$from["year"]."-".$from["month"]."-".$from["day"]."' AND '".$to["year"]."-".$to["month"]."-".$to["day"]."'";
    // var_dump($sql);

    $rows = $db->selectsRaw($sql);
    foreach ($rows as $i => $row) {
        $rows[$i]["profit"] = $row["price"] - $row["our_price"];
        $rows[$i]["total_price"] = $row["price"] * $row["count"];
        $rows[$i]["total_profit"] = $row["count"] * $rows[$i]["profit"];
    }

    return $rows;
}

if (isset($_POST["submit"])) {
    $show_result = $_POST["type"];
    $from = [
        "year" => $_POST["from_year"],
        "month" => $_POST["from_month"],
        "day" => $_POST["from_day"],
    ];
    $to = [
        "year" => $_POST["to_year"],
        "month" => $_POST["to_month"],
        "day" => $_POST["to_day"],
    ];

    // Convert jalali to gregorian
    $from = jalali_to_gregorian($from["year"], $from["month"], $from["day"]);
    $to = jalali_to_gregorian($to["year"], $to["month"], $to["day"]);

    // Re-key and change keys
    $from = [
        "year" => $from[0],
        "month" => $from[1],
        "day" => $from[2],
    ];
    $to = [
        "year" => $to[0],
        "month" => $to[1],
        "day" => $to[2],
    ];

    if ($show_result === "games" || $show_result === "all") {
        $result1 = reportGames($from, $to);
    }

    if ($show_result === "foods" || $show_result === "all") {
        $result2 = reportFoods($from, $to);
    }

}
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">

<a href="index.php">
    برگشت به اتاق فرمان
</a>
<br>


<center>
	<h1>حسابداری</h1>
</center>

<?php if (isset($show_result)) { ?>
    <?php if ($show_result === "games" || $show_result === "all") { ?>
        <table width="100%" border="1px">
            <tr>
                <th>سیستم</th>
                <th>از</th>
                <th>تا</th>
                <th>قیمت</th>
            </tr>
            <?php foreach ($result1 as $row) { ?>
                <tr>
                    <td><?=$row["family"]?> - <?=$row["family_index"]?> - <?=$row["family_daste"]?></td>
                    <td><?=jdate("Y/m/d h:j:s", $row["startTime"])?></td>
                    <td><?=jdate("Y/m/d h:j:s", $row["endTime"])?></td>
                    <td><?=$row["total_price"] === null ? "-" : number_format($row["total_price"]) . " تومان"?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <?php if ($show_result === "foods" || $show_result === "all") { ?>
        <table width="100%" border="1px">
            <tr>
                <th>جنس</th>
                <th>فی خرید</th>
                <th>فی فروش</th>
                <th>تعداد</th>
                <th>جمع فروش</th>
                <th>جمع سود</th>
            </tr>
            <?php foreach ($result2 as $row) { ?>
                <tr>
                    <td><?=$row["name"]?></td>
                    <td><?=number_format($row["our_price"])?></td>
                    <td><?=number_format($row["price"])?></td>
                    <td><?=$row["count"]?></td>
                    <td><?=number_format($row["total_price"])?></td>
                    <td><?=number_format($row["total_profit"])?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
<?php } ?>

<form action="" method="POST" style="display: flex; justify-content: center;flex-direction: column;">
    <!-- a form to ask from-date, to-date, type select -->
    <b>از تاریخ</b>

    <select name="from_year">
        <option value="1400">1399</option>
        <option value="1400">1400</option>
        <?php for ($this_year = 1401; $this_year <= $now_year; $this_year++) { ?>
            <option value="<?=$this_year?>"<?php print ($this_year == $now_year) ? " selected=\"\"" : ""?>><?=$this_year?></option>
        <?php } ?>
    </select>

    <select name="from_month">
        <?php for ($this_month = 1; $this_month <= 12; $this_month++) { ?>
            <option value="<?=$this_month?>"><?=$this_month?></option>
        <?php } ?>
    </select>

    <select name="from_day">
        <?php for ($this_day = 1; $this_day <= 31; $this_day++) { ?>
            <option value="<?=$this_day?>"><?=$this_day?></option>
        <?php } ?>
    </select>

    <!-- <input type="date" name="from-date"> -->
    <br>

    <b>تا تاریخ</b>
    <select name="to_year">
        <option value="1400">1400</option>
        <?php for ($this_year = 1401; $this_year <= $now_year; $this_year++) { ?>
            <option value="<?=$this_year?>"<?php print ($this_year == $now_year) ? " selected=\"\"" : ""?>><?=$this_year?></option>
        <?php } ?>
    </select>

    <select name="to_month">
        <?php for ($this_month = 1; $this_month <= 12; $this_month++) { ?>
            <option value="<?=$this_month?>"><?=$this_month?></option>
        <?php } ?>
    </select>

    <select name="to_day">
        <?php for ($this_day = 1; $this_day <= 31; $this_day++) { ?>
            <option value="<?=$this_day?>"><?=$this_day?></option>
        <?php } ?>
    </select>
    <!-- <input type="date" name="to-date"> -->
    <br>
    <b>نوع</b>
    <select name="type">
        <option value="games">بازی ها</option>
        <option value="foods">غذاها</option>
        <option value="coffee">کافه</option>
        <option value="all">همه</option>
    </select>
    <br>
    <button type="submit" name="submit">نمایش</button>
</form>

<?php
require "_core.php";

if(!isset($_GET["id"], $_GET["i"], $_GET["j"], $_GET["playId"], $_GET["k"])) {
	exit("error: no required params!");
}

$orders_food = $db->select("orders_food", ["id"=>$_GET["k"]]);
if($orders_food == null || $orders_food == []) {
	exit("Not found!");
}

$clauses = [
	"id"=>$orders_food["id"],
];
$db->delete("orders_food", $clauses);
// print_r($orders_food);
header("Location: endPlay.php?i=".$_GET["i"]."&j=".$_GET["j"]."&id=".$_GET["playId"]);

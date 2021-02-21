<?php
require "_core.php";

if(!isset($_GET["id"], $_GET["i"], $_GET["j"], $_GET["playId"])) {
	exit("error: no required params!");
}

$order = $db->select("orders", ["id"=>$_GET["id"]]);
if($order == null || $order == []) {
	exit("Not found!");
}

$clauses = [
	"id"=>$order["id"],
];
$db->delete("orders", $clauses);
// print_r($order);
header("Location: endPlay.php?i=".$_GET["i"]."&j=".$_GET["j"]."&id=".$_GET["playId"]);

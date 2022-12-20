<?php
date_default_timezone_set("Asia/Tehran");

require "phpedb.php";

function mytime() {
    return time();
}

$db = new database();
$db->db="gamenet";
$db->connect("localhost", "root", "");

require "jdf.php";

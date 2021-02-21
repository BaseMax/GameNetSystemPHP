<?php
date_default_timezone_set("Asia/Tehran");

require "phpedb.php";

$db = new database();
$db->db="gamenet";
$db->connect("localhost", "root", "01");

require "jdf.php";

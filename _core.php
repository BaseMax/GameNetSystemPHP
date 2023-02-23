<?php
session_start();

date_default_timezone_set("Asia/Tehran");

require "phpedb.php";
require "_secret.php";
require "jdf.php";

function mytime() {
    return time();
}

function fa2en($str) {
    $str = str_replace("۰", "0", $str);
    $str = str_replace("۱", "1", $str);
    $str = str_replace("۲", "2", $str);
    $str = str_replace("۳", "3", $str);
    $str = str_replace("۴", "4", $str);
    $str = str_replace("۵", "5", $str);
    $str = str_replace("۶", "6", $str);
    $str = str_replace("۷", "7", $str);
    $str = str_replace("۸", "8", $str);
    $str = str_replace("۹", "9", $str);
    return $str;
}

<?php
require "../../_core.php";
$plans = $db->selects("plans", [], "ORDER BY `id` ASC");

$result = [];

// $result["foods"] = $foods;

// Sections
$sections = [];
$i=1;
foreach($plans as $l=>$plan) {
    for($j=1;$j<=$plan["count"]; $j++) {
        $section = [];
        $last_order = $db->selectRaw("SELECT * FROM ".$db->db.".`orders` WHERE `planID` = ".$plan["id"]." AND `planIndexID` = ".$j." AND `status` = 1 ORDER BY `id` DESC;");
        // print_r($last_order);
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
        
        $section["plan"] = $plan;
        
        // $section["toPlans"] = $toPlans;

        $section["p1"] = $i;
        $section["p2"] = $j;
//      $section["p3"] = $plan["id"];
        $section["type"] = $l + 1;
        $section["name"] = "سیستم " .  $i ." - ". $plan["family"];
        
        $section["table"] = [];

        $clauses = [
            "planID"=>$plan["id"],
            "planIndexID"=>$j,
            "status"=>1,
        ];
        $price=0;
        $orders = $db->selects("orders", $clauses);
        if(isset($_GET["log"])) {
    //      print_r($orders);
        }
        foreach($orders as $order) {
            $table = [];

            $table["daste"] = $order["planDaste"];
            $table["date"] = jdate('Y/m/d H:i:s', $order["startTime"]);
            $table["endTime"] = ($order["endTime"] == null ? "در حال بازی" : jdate('Y/m/d H:i:s', $order["endTime"]));

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
            
            $table["time_min"] = $timeMin;      
            $table["time"] = $timeMin .  ' دقیقه';
            if($noYet === true) {
                $table["time"].= " (تا کنون)";
            }
            
            $table["timer"] = (int) $order["timer"];

            if($table["timer"] === 1) {
                $table["timer_left"] = jmktime() - $order["endTime"];
                $table["timer_left"] = -1 * round($table["timer_left"] / 60);
                $table["timer_left_price"] = $table["timer_left"] * $order["planPrice"];
                $table["timer_left_price"] = number_format($table["timer_left_price"]);
            }
            
            $table["id"] = $order["id"];

            $p = $timeMin * $order["planPrice"];
            $price += $p;
            $table["price"] = number_format($p);
            
            if(isset($_GET["log"])) {
                // print_r($table);
            }
            $section["table"][] = $table;
        }
        $section["price"] = number_format($price);
        $section["price_prepayment"] = number_format($play["prePayment"]);
        $section["price_payment"] = number_format($price - $play["prePayment"]);
        if(isset($_GET["log"])) {
            // print_r($section);
        }
        $sections[] = $section;
    }
}
$result["section"] = $sections;


// Table

$table = [];
$i=1;
foreach($plans as $im=>$plan) {
    $table[$im] = $plan;
    $table[$im]["items"] = [];

    for($j=1;$j<=$plan["count"]; $j++) {
        $clauses = [
            "planID"=>$im+1,
            "planIndexID"=>$j,
            "status"=>1,
        ];
        $last_active_order = $db->select("orders", $clauses, "ORDER BY `id` DESC");
        $color = "gray";
        if($last_active_order != [] && $last_active_order != null) {
            $color = "red";
            $last_active_order["time_in_min"]=jmktime() - $last_active_order["startTime"];
            $last_active_order["time_in_min"]=ceil($last_active_order["time_in_min"] / 60); // *
            $last_active_order["price"]=ceil($last_active_order["time_in_min"] * $last_active_order["planPrice"]);  // *
            $last_active_order["daste"]=$last_active_order["planDaste"];
        }
        else {
            // print "3";
            $color = "green";
        }

        if(!isset($last_active_order["daste"])) {
            $last_active_order["time_in_min"] = "-";
            $last_active_order["price"]="-";
            $last_active_order["daste"]="-";
            $item["timer"] = (int) 0;
        }
        else {
           // print_r($last_active_order);
            if($last_active_order["timer"] == 1) {
                $color = "gray";
                $item["timer_left"] = jmktime() - $last_active_order["endTime"];
                $item["timer_left"] = -1 * ceil($item["timer_left"] / 60); // *
            }
            $item["timer"] = (int) $last_active_order["timer"];
        }
        
    
        $item["id"] = $i;
    
        

        $item["color"] = $color;
    
        $item["family"] = $plan["family"];
    
        $sumPrice = 0;


        if(isset($last_active_order["playID"])) {
            $orders = $db->selects("orders", ["playID"=>$last_active_order["playID"]]);
            foreach($orders as $ix=>$order) {
                if($order["endTime"] == null || $order["endTime"] == "") {
                    $endTime = jmktime();
                    $orders[$ix]["endTime"] = $endTime;
                    $orders[$ix]["endTimeNow"] = true;
                }
                $timeDiff = $orders[$ix]["endTime"] - $order["startTime"];
                $timeMin = ceil($timeDiff / 60);
                $price = $timeMin * $orders[$ix]["planPrice"];

                $orders[$ix]["price"] = $price;
                $orders[$ix]["timeDiff"] = $timeDiff;
                $orders[$ix]["timeMin"] = $timeMin;

                $sumPrice+= $price;
            }
        }
        
        $play = [];
        $sumFood = (int) 0;
        if(isset(  $last_active_order["playID"] )) {
            $play = $db->select("plays", ["id"=>$last_active_order["playID"]]);
            if($play == null || $play == []) {
                $play["prePayment"] = (int) 0;
            }
            else {
                $playID = $play["id"];
                // Foods
                $foods = $db->selects("orders_food", ["playID"=>$play["id"]]);
            
                if(is_array($foods) and count($foods) > 0) {
                    foreach($foods as $food) {
                        $foods = $db->selects("orders_food", ["playID"=>$play["id"]]);
                        $_food = $db->select("foods", ["id"=>$food["foodID"]]);
                        $food["count"] = (int) $food["count"];
                        $food["price"] = (int) $food["price"];
                        $food["priceAll"] = (int) ($food["count"] * $food["price"]);
                        $sumFood += $food["priceAll"];
                    }
                }
            }
         }
        
        if($play == null || $play == []) {
            $play["prePayment"] = (int) 0;
        }

        $item["price_food"] = (int) $sumFood;

        $item["price_pre"] = (int) $play["prePayment"];

        $item["price_system"] = (int) $sumPrice;

        $item["price"] = ($item["price_system"] + $item["price_food"]) - $item["price_pre"];
    
        $item["time"] = $last_active_order["time_in_min"];
    
        $item["daste"] = $last_active_order["daste"];

        $table[$im]["items"][] = $item;

        $i++;
    }
}
$result["table"] = $table;

if(isset($_GET["log"])) {
    print_r($result);
}
else {
    print json_encode($result);
}


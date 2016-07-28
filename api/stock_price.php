<?php
    $team_id = isset($_GET["team_id"]) ? $_GET["team_id"] : "1";
    file_exists("class.php") ? include "class.php" : include "../class.php";
    if ($_SERVER['REMOTE_ADDR'] == "::1") {
        DB::$user = "root";
        DB::$password = "";
        DB::$dbName = "minet";
    } else {
        DB::$user = "classkwo_paya";
        DB::$password = "anand01";
        DB::$dbName = "classkwo_minet";
    }
    $results = DB::query("SELECT * FROM prices WHERE team_id = %s ORDER BY id DESC LIMIT 1", $team_id);
    foreach ($results as $row) {
        $price = $row["stock_price"];
    }
    $random_price = mt_rand(0, 5);
    if (mt_rand(0, 1) > 0) {
        $finalPrice = $price + $random_price;
    } else {
        $finalPrice = $price - $random_price;
    }
    echo $finalPrice;
    if (!isset($_GET["integer"])) {
        $random = mt_rand(1, 99);
        $random = $random < 10 ? "0" . $random : $random;
        echo "." . $random;
    }
?>

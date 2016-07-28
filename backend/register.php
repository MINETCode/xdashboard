<?php
    session_start();
    if (isset($_SESSION["username"])) {
        header("Location: ../index.php");
    }
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
    $results = DB::query("UPDATE teams SET username = %s, password = %s, email = %s, phone = %s, school_name = %s, created_at = %s, school_address = %s, registered = %s  WHERE id = %s", $_POST["username"], md5($_POST["password"]), $_POST["email"], $_POST["phone"], $_POST["school_name"], date("l jS \of F Y h:i:s A"), $_POST["school_address"], "1", $_POST["id"]);
    header("Location: ../login.php?registered=1");
?>

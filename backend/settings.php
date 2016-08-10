<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: ../index.php");
        } else {
            header("Location: https://x.minet.co");
        }
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
    $results = DB::query("SELECT password from teams where username = %s", $_SESSION["username"]);
    foreach ($results as $row) {
        $current_pass = $row["password"];
    }
    if (md5($_POST["old_password"]) == $current_pass) {
        $results = DB::query("UPDATE teams SET password = %s, email = %s, phone = %s, school_name = %s, school_address = %s  WHERE id = %s", md5($_POST["new_password"]), $_POST["email"], $_POST["phone"], $_POST["schoolName"], $_POST["schoolAddress"], $_SESSION["id"]);
        $results = DB::query("INSERT into eventlog (username, category, verb, event, datetime) VALUES (%s, %s, %s, %s, %s)", $_SESSION["username"], "settings", "changed", "password", time());
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: ../settings.php?password=1");
        } else {
            header("Location: https://x.minet.co/settings?password=1");
        }
    } else {
        $results = DB::query("UPDATE teams SET email = %s, phone = %s, school_name = %s, school_address = %s WHERE id = %s", $_POST["email"], $_POST["phone"], $_POST["schoolName"], $_POST["schoolAddress"], $_SESSION["id"]);
        $results = DB::query("INSERT into eventlog (username, category, verb, event, datetime) VALUES (%s, %s, %s, %s, %s)", $_SESSION["username"], "settings", "changed", "settings", time());
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: ../settings.php?updated=1");
        } else {
            header("Location: https://x.minet.co/settings?updated=1");
        }
    }
?>

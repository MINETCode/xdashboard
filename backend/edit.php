<?php
    session_start();
    if (isset($_SESSION["username"])) {
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
    $results = DB::query("UPDATE teams SET startup_name = %s, startup_info = %s, startup_hero = %s, startup_subheading = %s, startup_logo = %s WHERE id = %s", $_POST["startup_name"], $_POST["startup_info"], $_POST["startup_hero"], $_POST["startup_subheading"], $_POST["startup_logo"], $_SESSION["id"]);
    $results = DB::query("INSERT into eventlog (username, category, verb, event, datetime) VALUES (%s, %s, %s, %s, %s)", $_SESSION["username"], "profile", "updated", "profile", time());
    if ($_SERVER['REMOTE_ADDR'] == "::1") {
        header("Location: ../profile.php?updated=1");
    } else {
        header("Location: https://x.minet.co/profile?updated=1");
    }
?>

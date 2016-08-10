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
    $results = DB::query("UPDATE teams SET design_participant_1_name = %s, design_participant_1_email = %s, design_participant_2_name = %s, design_participant_2_email = %s, design_participant_3_name = %s, design_participant_3_email = %s, programming_participant_1_name = %s, programming_participant_1_email = %s, programming_participant_2_name = %s, programming_participant_2_email = %s, quiz_participant_1_name = %s, quiz_participant_1_email = %s, quiz_participant_2_name = %s, quiz_participant_2_email = %s, gaming_participant_1_name = %s, gaming_participant_1_email = %s, gaming_participant_2_name = %s, gaming_participant_2_email = %s, speaking_participant_1_name = %s, speaking_participant_1_email = %s WHERE id = %s", $_POST["design_participant_1_name"], $_POST["design_participant_1_email"], $_POST["design_participant_2_name"], $_POST["design_participant_2_email"], $_POST["design_participant_3_name"], $_POST["design_participant_3_email"], $_POST["programming_participant_1_name"], $_POST["programming_participant_1_email"], $_POST["programming_participant_2_name"], $_POST["programming_participant_2_email"], $_POST["quiz_participant_1_name"], $_POST["quiz_participant_1_email"], $_POST["quiz_participant_2_name"], $_POST["quiz_participant_2_email"], $_POST["gaming_participant_1_name"], $_POST["gaming_participant_1_email"], $_POST["gaming_participant_2_name"], $_POST["gaming_participant_2_email"], $_POST["speaking_participant_1_name"], $_POST["speaking_participant_1_email"], $_POST["id"] );
    $results = DB::query("INSERT into eventlog (username, category, verb, event, datetime) VALUES (%s, %s, %s, %s, %s)", $_SESSION["username"], "profile", "updated", "team information", time());
    if ($_SERVER['REMOTE_ADDR'] == "::1") {
        header("Location: ../team.php?updated=1");
    } else {
        header("Location: https://x.minet.co/team?updated=1");
    }
?>

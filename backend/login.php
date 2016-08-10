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
    $username = $_POST["username"];
    $password = $_POST["password"];
    $results = DB::query("SELECT * FROM teams WHERE username=%s AND password=%s", $username, md5($password));
    $n_results = 0;
    foreach ($results as $row) {
        $n_results++;
        $id = $row["id"];
        $school_name = $row["school_name"];
    }
    if ($n_results > 0) {
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $id;
        $_SESSION["school_name"] = $school_name;
        $results = DB::query("INSERT into eventlog (username, category, verb, event, datetime) VALUES (%s, %s, %s, %s, %s)", $_SESSION["username"], "sessions", "started", "session from " . $_SERVER["REMOTE_ADDR"], time());
        echo "Login Yes";
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: ../index.php");
        } else {
            header("Location: https://x.minet.co");
        }
    } else {
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: ../login.php?try=1");
        } else {
            header("Location: https://x.minet.co/login?try=1");
        }
    }
?>

<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
    }
    function _ago($tm, $rcs = 0) {
        $cur_tm = time(); $dif = $cur_tm-$tm;
        $pds = array('second','minute','hour','day','week','month','year','decade');
        $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
        for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

        $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
        if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
        return $x;
    }
?>
<!doctype html>
<html>
    <head>
        <title>X</title>
        <meta charset="utf-8">
        <meta name="author" content="The MINET Team">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="style.css">

        <link rel="icon" type="image/png" href="img/icon.png">
        <link rel="apple-touch-icon-precomposed" href="img/icon.png">
        <meta name="theme-color" content="#2979ff">
    </head>
    <body>
        <header id="masthead">
            <div class="container">
                <div class="half">
                    <a href="index.php" class="logo">
                        MINET
                    </a>
                </div>
                <div class="half">
                    <nav>
                        <ul>
                            <li><a href="index.php">Dashboard</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="startups.php">Startups</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li><a href="logout.php">Log out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="card">
                <h1>
                    Events
                </h1>
                <?php
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
                    $results = DB::query("SELECT * FROM eventlog WHERE username = %s ORDER BY id DESC", $_SESSION["username"]);
                    $nResults = 0;
                    foreach ($results as $row) {
                        echo '
                        <div class="event">
                            <div>
                                You ' . $row["verb"] . ' your ' . $row["event"] . '.
                            </div>
                            <div class="sub">
                                <span>' . ucfirst($row["category"]) . '</span> &middot;
                                ' . _ago($row["datetime"]) . ' ago
                            </div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
    <script src="https://use.typekit.net/ucv3orh.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>

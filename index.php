<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
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
    function _ago($tm, $rcs = 0) {
        $cur_tm = time(); $dif = $cur_tm-$tm;
        $pds = array('second','minute','hour','day','week','month','year','decade');
        $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
        for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

        $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
        if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
        return $x;
    }
?><!doctype html>
<html>
    <head>
        <title>X</title>
        <link rel="stylesheet" href="style.css">
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
                            <li class="active"><a href="index.php">Dashboard</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="startups.php">Startups</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li><a href="logout.php">Log out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="card">
            <h1><?php echo $_SESSION["school_name"]; ?> &middot; <span class="up" id="stock_price">00.00</span></h1>
            <div class="eventlog">
                <h3>Events</h3>
                <?php
                    $results = DB::query("SELECT * FROM eventlog WHERE username = %s ORDER BY id DESC LIMIT 20", $_SESSION["username"]);
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
        <script>
            setInterval(function() {
                var request0 = new XMLHttpRequest();
                request0.open("POST", "api/stock_price.php?team_id=<?php echo $_SESSION["id"]; ?>", true);
                request0.send();
                request0.onload = function() {
                    var previousPrice = document.querySelector("#stock_price").innerHTML;
                    document.querySelector("#stock_price").innerHTML = request0.responseText;
                    if (parseInt(request0.responseText) > parseInt(previousPrice)) {
                        document.querySelector("#stock_price").classList.add("up");
                        document.querySelector("#stock_price").classList.remove("down");
                    } else {
                        document.querySelector("#stock_price").classList.remove("up");
                        document.querySelector("#stock_price").classList.add("down");
                    }
                }
            }, 5000);
        </script>
    </body>
</html>

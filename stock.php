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
        <?php include "backend/header.php"; ?>
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
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "index.php" : "https://x.minet.co"; ?>">Dashboard</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "profile.php" : "https://x.minet.co/profile"; ?>">Profile</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "startups.php" : "https://x.minet.co/startups"; ?>">Startups</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "settings.php" : "https://x.minet.co/settings"; ?>">Settings</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "logout.php" : "https://x.minet.co/logout"; ?>">Log out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="card">
                <h1>
                    Stock Price
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
                    $results = DB::query("SELECT * FROM prices WHERE team_id = %s ORDER BY id DESC", $_SESSION["id"]);
                    $nResults = 0;
                    foreach ($results as $row) {
                        echo '
                        <div class="event">
                            <span id="stock_price" style="float: left; font-size: 200%; margin-right: 15px;">' . $row["stock_price"] . '</span>
                            <div>
                                ' . $row["reason"] . '
                            </div>
                            <div class="sub">
                                <span>' . _ago($row["time"]) . ' ago</span>
                            </div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

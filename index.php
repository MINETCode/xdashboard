<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            header("Location: login.php");
        } else {
            header("Location: https://x.minet.co/login");
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
        <?php include "backend/header.php"; ?>
    </head>
    <body class="big">
        <div class="update_time"></div>
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
                            <li class="active"><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "index.php" : "https://x.minet.co"; ?>">Dashboard</a></li>
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
            <div class="row">
                <div class="half">
                    <div class="card">
                        <h3>School Info</h3>
                        <p class="startup-info">
                            <?php
                                $results = DB::query("SELECT * FROM teams WHERE username = %s LIMIT 1", $_SESSION["username"]);
                                foreach ($results as $row) {
                                    $address = $row["school_address"];
                                    $email = $row["email"];
                                    $phone = $row["phone"];
                                }
                            ?>
                            <strong>Institution</strong><?php echo $_SESSION["school_name"]; ?><br>
                            <strong>Address</strong><?php echo $address; ?><br>
                            <strong>Email</strong><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a><br>
                        </p>
                        <div class="help-link">
                            <a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "settings.php" : "https://x.minet.co/settings"; ?>">Edit</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="eventlog">
                            <h3>Events</h3>
                            <?php
                                $results = DB::query("SELECT * FROM eventlog WHERE username = %s ORDER BY id DESC LIMIT 5", $_SESSION["username"]);
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
                            <div class="help-link">
                                <a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "events.php" : "https://x.minet.co/events"; ?>">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="half">
                    <div class="card">
                        <div class="help-link">
                            <a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "stock.php" : "https://x.minet.co/stock"; ?>">Details</a>
                        </div>
                        <h3 style="margin-bottom: 0">Stock Price</h3>
                        <div class="big up" id="stock_price">
                            <?php
                                $result = DB::query("SELECT stock_price from prices WHERE team_id = %s ORDER BY id DESC LIMIT 1", $_SESSION["id"]);
                                foreach ($result as $row) {
                                    $price = $row["stock_price"];
                                    $random = mt_rand(1, 99);
                                    $random = $random < 10 ? "0" . $random : $random;
                                    $random_price = mt_rand(0, 5);
                                    if (mt_rand(0, 1) > 0) {
                                        $finalPrice = $price + $random_price;
                                        $class = "up";
                                    } else {
                                        $finalPrice = $price - $random_price;
                                        $class = "down";
                                    }
                                }
                                echo $finalPrice . "." . $random;
                            ?>
                        </div>
                        <div class="row">
                            <div class="half">
                                <p>
                                    Current Average: <strong>&#x20b9; <?php
                                        $result = DB::query("SELECT stock_price from prices WHERE team_id = %s ORDER BY id DESC LIMIT 1", $_SESSION["id"]);
                                        foreach ($result as $row) {
                                            echo $row["stock_price"];
                                        }
                                    ?></strong>
                                </p>
                            </div>
                            <div class="half">
                                <p>
                                    All-time Average: <strong>&#x20b9; <?php
                                        $result = DB::query("SELECT stock_price from prices WHERE team_id = %s", $_SESSION["id"]);
                                        $sum = 0; $i = 0;
                                        foreach ($result as $row) {
                                            $i++;
                                            $sum += intval($row["stock_price"]);
                                        }
                                        echo $sum / $i;
                                    ?></strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="half">
                                <p style="margin-top: 0">
                                    All-time High: <strong>&#x20b9; <?php
                                        $result = DB::query("SELECT stock_price from prices WHERE team_id = %s ORDER BY stock_price DESC LIMIT 1", $_SESSION["id"]);
                                        foreach ($result as $row) {
                                            echo $row["stock_price"];
                                        }
                                    ?></strong>
                                </p>
                            </div>
                            <div class="half">
                                <p style="margin-top: 0">
                                    All-time Low: <strong>&#x20b9; <?php
                                        $result = DB::query("SELECT stock_price from prices WHERE team_id = %s ORDER BY stock_price ASC LIMIT 1", $_SESSION["id"]);
                                        foreach ($result as $row) {
                                            echo $row["stock_price"];
                                        }
                                    ?></strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card teams">
                        <div class="help-link">
                            <a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "team.php" : "https://x.minet.co/team"; ?>">Edit</a>
                        </div>
                        <h3>Team</h3>
                        <div class="row team">
                            <?php
                                $result = DB::query("SELECT * FROM teams WHERE id = %s", $_SESSION["id"]);
                                $n_participants = 0;
                                foreach ($result as $row) {
                                    $events = array("design", "programming", "quiz", "gaming", "speaking");
                                    foreach ($events as $event) {
                                        for ($i = 1; $i < 4; $i++) {
                                            $i_row = $event . "_participant_" . $i;
                                            if (isset($row[$i_row . "_name"])) {
                                                if ($row[$i_row . "_name"] != "") {
                                                    $n_participants++;
                                                    echo '
                                                        <div class="half">
                                                            <p>
                                                                <img src="https://www.gravatar.com/avatar/' . md5($row[$i_row . "_email"]) . '?d=retro">
                                                                ' . $row[$i_row . "_name"] . '
                                                            </p>
                                                        </div>
                                                    ';
                                                }
                                            }
                                        }
                                    }
                                }
                                if ($n_participants == 0) {
                                    echo "
                                    <div style='text-align:center'>
                                        <p>
                                            <img style='float: none; border-radius: 0; background: none; width: 50%; height: auto; opacity: 0.5' alt='' src='img/sleeper.png'>
                                        </p>
                                        <p style='color:#aaa'>You haven&rsquo;t added your team yet.</p>
                                        <p>
                                            <a class='button' href='" .
                                                "https://x.minet.co/team"
                                            . "'>Add your Team</a>
                                        </p>
                                    </div>
                                    ";
                                } else {
                                    echo "<div style='width:100%;clear:both'></div>";
                                    echo "<p style='color:#aaa'>There are " . $n_participants . " members in your team.</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
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
            }, 30000);
        </script>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

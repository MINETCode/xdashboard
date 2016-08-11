<!doctype html>
<html>
    <head>
        <?php include "backend/header.php"; ?>
    </head>
    <body style="max-width: 800px">
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
                            <li class="active"><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "startups.php" : "https://x.minet.co/startups"; ?>">Startups</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "settings.php" : "https://x.minet.co/settings"; ?>">Settings</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "logout.php" : "https://x.minet.co/logout"; ?>">Log out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="update_time"></div>
        <div class="card">
            <h1>Startups</h1>
            <div id="leaderboard">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center">
                                #
                            </th>
                            <th>
                                Team
                            </th>
                            <th>
                                Stock Price
                            </th>
                            <th>
                                Startup Profile
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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
                            $results = DB::query("SELECT teams.school_name, teams.level, teams.startup_name, teams.id, prices.stock_price FROM teams, prices WHERE teams.id = prices.team_id GROUP BY teams.school_name ORDER BY prices.id DESC");
                            $i = 0;
                            $cryptXlevel = 0;
                            foreach ($results as $row) {
                                $cryptXlevel = $row["level"];
                                $price = $row["stock_price"];
                                $teamID = $row["id"];
                                $startup_name = $row["startup_name"];
                                if ($startup_name == "") {
                                    $random1 = array("Uber", "Content", "Tweet", "Web", "Attention", "Blog", "Tech", "Music", "Net", "Sales", "Social", "You", "Web", "Link", "Simple");
                                    $random2 = array("force", "Hunt", "Explorer", "ify", "ly", "App", "Trust", "Burner", "Talk", "book", "loop", "Spot", "gator", "vibes", "cut", "set", "leaf", "world", "Jag", "shots", "Egg");
                                    $random_keys1 = array_rand($random1, 1);
                                    $random_keys2 = array_rand($random2, 1);
                                    $startup_name = $random1[$random_keys1];
                                    $startup_name .= $random2[$random_keys2];
                                    $startup_name .= " *";
                                }
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
                                $cryptXlevelPrice = $cryptXlevel * 100;
                                $finalPrice += $cryptXlevelPrice;
                                echo '<tr>
                                    <td style="text-align: center">
                                        ' . ++$i . '
                                    </td>
                                    <td>
                                        <strong>' . $startup_name . '</strong><br>
                                        <span>' . $row["school_name"] . '</span>
                                    </td>
                                    <td>
                                        <span class="' . $class . ' med stock_price_' . $row["id"] . '" id="stock_price">' . $finalPrice . '.' . $random . '</span>
                                    </td>
                                    <td style="text-align: center">
                                        <a href="https://x.minet.co/profile?id=' . $teamID . '">View Profile</a> <span style="font-size: 175%; text-decoration: none; color: #69e; display: inline-block; transform: translateY(2px)">&rsaquo;</span>
                                    </td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
                <p>
                    * = Randomly-generated temporary startup name.
                </p>
            </div>
        </div>
        <script>
        setInterval(function() {
        <?php
            for ($i = 1; $i < 17; $i++) {
                echo '
                        var request' . $i . ' = new XMLHttpRequest();
                        request' . $i . '.open("POST", "api/stock_price.php?team_id=' . $i .'", true);
                        request' . $i . '.send();
                        request' . $i . '.onload = function() {
                            var previousPrice = document.querySelector(".stock_price_' . $i .'").innerHTML;
                            document.querySelector(".stock_price_' . $i .'").innerHTML = request' . $i . '.responseText;
                            if (parseInt(request' . $i . '.responseText) > parseInt(previousPrice)) {
                                document.querySelector(".stock_price_' . $i .'").classList.add("up");
                                document.querySelector(".stock_price_' . $i .'").classList.remove("down");
                            } else {
                                document.querySelector(".stock_price_' . $i .'").classList.remove("up");
                                document.querySelector(".stock_price_' . $i .'").classList.add("down");
                            }
                        }
                ';
            }
        ?>
        }, 30000);
    </script>
    <?php include "backend/footer.php"; ?>
    </body>
</html>

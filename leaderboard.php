<!doctype html>
<html>
    <head>
        <title>X</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="update_time"></div>
        <div class="card">
            <h1>Leaderboard</h1>
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
                            $results = DB::query("SELECT teams.school_name, teams.id, prices.stock_price FROM teams, prices WHERE teams.id = prices.team_id ORDER BY prices.stock_price DESC");
                            $i = 0;
                            foreach ($results as $row) {
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
                                echo '<tr>
                                    <td style="text-align: center">
                                        ' . ++$i . '
                                    </td>
                                    <td>
                                        ' . $row["school_name"] . '
                                    </td>
                                    <td>
                                        <span class="' . $class . ' med stock_price_' . $row["id"] . '" id="stock_price">' . $finalPrice . '.' . $random . '</span>
                                    </td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
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
    </body>
</html>

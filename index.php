<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
?><!doctype html>
<html>
    <head>
        <title>X</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <p>

        </p>
        <div class="card">
            <h1><?php echo $_SESSION["school_name"]; ?></h1>
            <span class="big up" id="stock_price">00.00</span>
            <h2><a href="leaderboard.php">Leaderboard</a></h2>
            <h2><a href="settings.php">Settings</a></h2>
            <h2><a href="logout.php">Log out</a></h2>
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

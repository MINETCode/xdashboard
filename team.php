<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
    }
?>
<!doctype html>
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
                    Team
                </h1>
            </div>
        </div>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

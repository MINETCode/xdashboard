<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
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
            $results = DB::query("SELECT startup_name, school_name, startup_info, startup_hero, startup_subheading, startup_logo FROM teams WHERE id = %s", $_SESSION["id"]);
            foreach ($results as $row) {
                $startup_name = $row["startup_name"];
                $startup_info = $row["startup_info"];
                $startup_hero = $row["startup_hero"];
                $startup_subheading = $row["startup_subheading"];
                $startup_logo = $row["startup_logo"];
            }
        ?>
        <div class="container">
            <form action="backend/edit.php" method="post">
                <fieldset>
                    <h1>
                        Edit Your Profile
                    </h1>
                    <p>
                        <?php
                            if (isset($_GET["updated"])) {
                                echo "<strong>Your profile has been updated. </strong>";
                            }
                        ?>
                    </p>
                    <p>
                        <label for="startup_name">Startup Name:</label>
                        <input name="startup_name" id="startup_name" type="text" value="<?php echo $startup_name; ?>" placeholder="Enter your startup's name">
                    </p>
                    <p>
                        <label for="startup_subheading">Subheading:</label>
                        <input name="startup_subheading" id="startup_subheading" type="text" value="<?php echo $startup_subheading; ?>" placeholder="Enter your startup's description in 3-4 words">
                    </p>
                    <p>
                        <label for="startup_logo">Startup Logo URL:</label>
                        <input name="startup_logo" id="startup_logo" type="text" value="<?php echo $startup_logo; ?>" placeholder="Format: PNG, Size: 160&times;160">
                    </p>
                    <p>
                        <label for="startup_hero">Startup Cover Image URL:</label>
                        <input name="startup_hero" id="startup_hero" type="text" value="<?php echo $startup_hero; ?>" placeholder="Format: PNG, full-width image.">
                    </p>
                    <p>
                        <label for="startup_info">Startup Description:</label>
                        <textarea name="startup_info" id="startup_info" type="text" placeholder="Enter at least one paragraph about your startup." style="resize:none;font:inherit"><?php echo $startup_info; ?></textarea>
                    </p>
                    <p>
                        <input type="submit" value="Save Profile">
                    </p>
                </fieldset>
            </form>
        </div>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

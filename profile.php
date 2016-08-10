<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
    }
?>
<?php
    if (!isset($_GET["id"])) {
        header("Location: ?id=" . $_SESSION["id"]);
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
    $results = DB::query("SELECT startup_name, school_name, startup_info, startup_hero, startup_subheading, startup_logo FROM teams WHERE id = %s", $_GET["id"]);
    foreach ($results as $row) {
        $startup_info = $row["startup_info"];
        if ($startup_info == "") {
            $startup_info = "Information";
        }
        $startup_name = $row["startup_name"];
        $startup_hero = $row["startup_hero"];
        $school_name = $row["school_name"];
        $startup_logo = $row["startup_logo"];
        $startup_subheading = $row["startup_subheading"];
        if ($startup_subheading == "") {
            $startup_subheading = "<span style='color:#888'>eg. YouTube for cat videos</span>";
        }
        if ($startup_hero == "") {
            $startup_hero = "https://x.minet.co/img/image.png";
        }
        if ($startup_logo == "") {
            $startup_logo = "NONE";
        }
        if ($startup_name == "") {
            $random1 = array("Uber", "Content", "Tweet", "Web", "Attention", "Blog", "Tech", "Music", "Net", "Sales", "Social", "You", "Web", "Link", "Simple");
            $random2 = array("force", "Hunt", "Explorer", "ify", "ly", "App", "Trust", "Burner", "Talk", "book", "loop", "Spot", "gator", "vibes", "cut", "set", "leaf", "world", "Jag", "shots", "Egg");
            $random_keys1 = array_rand($random1, 1);
            $random_keys2 = array_rand($random2, 1);
            $startup_name = $random1[$random_keys1];
            $startup_name .= $random2[$random_keys2];
            $startup_name .= " *";
        }
    }
?>
<!doctype html>
<html>
    <head>
        <title><?php echo $startup_name; ?> &middot; X 2016</title>
        <?php include "backend/header.php"; ?>
    </head>
    <body style="max-width: 720px">
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
                            <li class="active"><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "profile.php" : "https://x.minet.co/profile"; ?>">Profile</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "startups.php" : "https://x.minet.co/startups"; ?>">Startups</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "settings.php" : "https://x.minet.co/settings"; ?>">Settings</a></li>
                            <li><a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "logout.php" : "https://x.minet.co/logout"; ?>">Log out</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
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
                            }
                        }
                    }
                }
            }
        ?>
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="a3per s-logo">
                        <figure>
                            <?php
                                if ($startup_logo == "NONE") {
                                    $colors = array("#1ABC9C", "#16A085", "#2ECC71", "#27AE60", "#3498DB", "#2980B9", "#9B59B6", "#8E44AD", "#34495E", "#2C3E50", "#F1C40F", "#F39C12", "#E67E22", "#D35400", "#E74C3C", "#C0392B", "tomato");
                                    $random_keysx = array_rand($colors, 1);
                                    $color_final = $colors[$random_keysx];
                                    echo "<div class='default-logo' style='background: " . $color_final . "'>
                                    " . $startup_name[0] . "
                                    </div>";
                                } else {
                                    echo "<img alt='' src='" . $startup_logo . "'>";
                                }
                            ?>
                        </figure>
                    </div>
                    <div class="a7per">
                        <?php
                            if ($_GET["id"] == $_SESSION["id"]) {
                        ?>
                        <a href="<?php echo $_SERVER['REMOTE_ADDR'] == "::1" ? "edit.php" : "https://x.minet.co/edit"; ?>" class="button edit-btn-profile">
                            Edit Profile
                        </a>
                        <?php } ?>
                        <h1 class="s-name">
                            <?php echo $startup_name; ?>
                        </h1>
                        <h3 class="s-subheading">
                            <?php echo $startup_subheading; ?>
                        </h3>
                        <p style="line-height: 1.9">
                            <?php echo $school_name; ?><br>
                            Team Size: <?php echo $n_participants; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <img style="width: 100%" src="<?php echo $startup_hero; ?>">
            </div>
            <div class="card">
                <h1 style="text-align: left">Startup Info</h1>
                <p>
                    <?php echo $startup_info; ?>
                </p>
            </div>
            <div class="card team team-box">
                <h1 style="text-align: left; margin-bottom: 0">Team</h1>
                <?php
                    $result = DB::query("SELECT * FROM teams WHERE id = %s", $_GET["id"]);
                    $n_participants_a = 0;
                    foreach ($result as $row) {
                        $events = array("design", "programming", "quiz", "gaming", "speaking");
                        foreach ($events as $event) {
                            for ($i = 1; $i < 4; $i++) {
                                $i_row = $event . "_participant_" . $i;
                                if (isset($row[$i_row . "_name"])) {
                                    if ($row[$i_row . "_name"] != "") {
                                        $n_participants_a++;
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
                    if ($n_participants_a == 0) {
                        echo "<p>
                        Nobody yet. :(
                        </p>";
                    }
                ?>
            </div>
        </div>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

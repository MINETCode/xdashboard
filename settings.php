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
                            <li><a href="index.php">Dashboard</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="startups.php">Startups</a></li>
                            <li class="active"><a href="settings.php">Settings</a></li>
                            <li><a href="logout.php">Log out</a></li>
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
            $results = DB::query("SELECT * FROM teams WHERE username = %s", $_SESSION["username"]);
            foreach ($results as $row) {
                $username = $row["username"];
                $school_name = $row["school_name"];
                $school_address = $row["school_address"];
                $phone = $row["phone"];
                $email = $row["email"];
            }
        ?>
        <form action="backend/settings.php" method="post">
            <fieldset>
                <h1>
                    Settings
                </h1>
                <?php
                    if (isset($_GET["updated"])) {
                        echo "<p><strong>Settings updated successfully.</strong></p>";
                    }
                ?>
                <?php
                    if (isset($_GET["password"])) {
                        echo "<p><strong>Settings and password updated successfully.</strong></p>";
                    }
                ?>
                <p>
                    <label>Username:</label>
                    <input value="<?php echo $username; ?>" type="text" style="margin-top: 0" disabled>
                </p>
                <p>
                    <label for="label_schoolName">Institution:</label>
                    <input name="schoolName" id="label_schoolName" value="<?php echo $school_name; ?>" type="text" required>
                </p>
                <p>
                    <label for="label_schoolAddress">Address:</label>
                    <input name="schoolAddress" id="label_schoolAddress" value="<?php echo $school_address; ?>" type="text" required>
                </p>
                <p>
                    <label for="label_email">Email:</label>
                    <input name="email" id="label_email" value="<?php echo $email; ?>" type="email" required>
                </p>
                <p>
                    <label for="label_phone">Contact No.:</label>
                    <input name="phone" id="label_phone" value="<?php echo $phone; ?>" type="tel" required>
                </p>
                <p>
                    <label for="label_old_password">Current Password:</label>
                    <input name="old_password" type="password" id="label_old_password" placeholder="Enter your current password (optional)">
                </p>
                <p>
                    <label for="label_new_password">New Password:</label>
                    <input name="new_password" type="password" id="label_new_password" placeholder="Enter your new password (optional)">
                </p>
                <p>
                    <input type="submit" value="Save">
                </p>
            </fieldset>
        </form>
    </body>
</html>

<?php
    session_start();
    if (isset($_SESSION["username"])) {
        header("Location: index.php");
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
?>
<!doctype html>
<html>
    <head>
        <title>X</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            if (!isset($_GET["inviteCode"])) {
                echo '
                <form method="get"><fieldset>
                <p>
                    <label for="label_inviteCode">Invitation Code:</label>
                    <input name="inviteCode" type="text" id="label_inviteCode" placeholder="Enter your invitation code" required>
                </p><p>
                    <input type="submit" value="Continue to Registration">
                </p>
                </fieldset></form>
                ';
            } else {
                $results = DB::query("SELECT * FROM teams WHERE invitecode = %s", $_GET["inviteCode"]);
                $nResults = 0;
                foreach ($results as $row) {
                    $nResults++;
                    $school_name = $row["school_name"];
                    $school_address = $row["school_address"];
                    $phone = $row["phone"];
                    $email = $row["email"];
                    $id = $row["id"];
                    $registered = $row["registered"];
                }
                if ($nResults > 0) {
                    if ($registered == 0) {
        ?>
        <form action="backend/register.php" method="post">
            <fieldset>
                <h1>
                    Registration
                </h1>
                <p>
                    <label>Invitation Code:</label>
                    <input type="text" value="<?php echo $_GET["inviteCode"]; ?>" disabled>
                </p>
                <p>
                    <label for="label_schoolName">Institution Name:</label>
                    <input name="school_name" type="text" id="label_schoolName" placeholder="Enter your school, eg. The Mother's International School" value="<?php echo $school_name; ?>" required>
                </p>
                <p>
                    <label for="label_schoolAddress">Institution Address:</label>
                    <input name="school_address" type="text" id="label_schoolAddress" placeholder="Enter your school address" value="<?php echo $school_address; ?>" required>
                </p>
                <p>
                    <label for="label_username">Username:</label>
                    <input name="username" type="text" id="label_username" placeholder="Enter your username (no spaces)" autofocus style="margin-top: 0" required>
                </p>
                <p>
                    <label for="label_password">Password:</label>
                    <input name="password" type="password" id="label_password" placeholder="Enter your password" required>
                </p>
                <p>
                    <label for="label_email">Email:</label>
                    <input name="email" type="email" id="label_email" placeholder="Enter your school/club's official email address" value="<?php echo $email; ?>" required>
                </p>
                <p>
                    <label for="label_phone">Contact Number:</label>
                    <input name="phone" type="num" id="label_phone" placeholder="Enter your school/club's official phone number"  value="<?php echo $phone; ?>" required>
                </p>
                <p>
                    <input type="checkbox" disabled checked style="float: left; width: auto; transform: scale(1.5) translateY(2px); margin-right: 10px"> <?php echo $school_name; ?> will participate at MINET X 2016 organized by The Mother's International School on August 16&ndash;17, 2016.
                </p>
                <p>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" value="Register and RSVP">
                </p>
                <p>
                    <span><a href="login.php">Sign in</a> if you already have an account.</span>
                </p>
            </fieldset>
        </form>
        <?php
    } else {
            echo '
            <form>
            <fieldset>
            <h1>Registration Error</h1>
            <p>
            You have already completed your registration. You may now sign in.
            </p>
            <p>
            <a href="login.php">Login</a>
            </p>
            </fieldset>
            </form>';
    }
    } else {
        echo '
        <form method="get"><fieldset>
        <h1>Registration Error</h1>
        <p>
            You have entered an invalid invitation code.
        </p>
        <p>
            <a href="register.php">Go Back</a>
        </p>
        </fieldset></form>';
    }
}
        ?>
    </body>
</html>

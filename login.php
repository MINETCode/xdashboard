<?php
    session_start();
    if (isset($_SESSION["username"])) {
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
        <form action="backend/login.php" method="post">
            <fieldset>
                <h1>
                    MINET X 2016
                </h1>
                <?php
                    if (isset($_GET["try"])) {
                        echo "<p><strong>Incorrect username/password combination</strong></p>";
                    }
                ?>
                <?php
                    if (isset($_GET["logout"])) {
                        echo "<p><strong>Successfully logged out.</strong></p>";
                    }
                ?>
                <?php
                    if (isset($_GET["registered"])) {
                        echo "<p><strong>Sign up complete. You can now log in and complete your registration.</strong></p>";
                    }
                ?>
                <p>
                    <label for="label_username">Username:</label>
                    <input name="username" type="text" id="label_username" placeholder="Enter your username" autofocus style="margin-top: 0">
                </p>
                <p>
                    <label for="label_password">Password:</label>
                    <input name="password" type="password" id="label_password" placeholder="Enter your password" autofocus>
                </p>
                <p>
                    <input type="submit" value="Sign in">
                </p>
                <p>
                    <span><a href="register.php">Sign up</a> if you don't already have an account.</span>
                </p>
            </fieldset>
        </form>
    </body>
</html>

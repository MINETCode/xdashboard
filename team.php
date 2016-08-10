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
            $results = DB::query("SELECT * FROM teams WHERE username = %s", $_SESSION["username"]);
            foreach ($results as $row) {
                $design_participant_1_name = $row["design_participant_1_name"];
                $design_participant_1_email = $row["design_participant_1_email"];
                $design_participant_2_name = $row["design_participant_2_name"];
                $design_participant_2_email = $row["design_participant_2_email"];
                $design_participant_3_name = $row["design_participant_3_name"];
                $design_participant_3_email = $row["design_participant_3_email"];
                $programming_participant_1_name = $row["programming_participant_1_name"];
                $programming_participant_1_email = $row["programming_participant_1_email"];
                $programming_participant_2_name = $row["programming_participant_2_name"];
                $programming_participant_2_email = $row["programming_participant_2_email"];
                $quiz_participant_1_name = $row["quiz_participant_1_name"];
                $quiz_participant_1_email = $row["quiz_participant_1_email"];
                $quiz_participant_2_name = $row["quiz_participant_2_name"];
                $quiz_participant_2_email = $row["quiz_participant_2_email"];
                $gaming_participant_1_name = $row["gaming_participant_1_name"];
                $gaming_participant_1_email = $row["gaming_participant_1_email"];
                $gaming_participant_2_name = $row["gaming_participant_2_name"];
                $gaming_participant_2_email = $row["gaming_participant_2_email"];
                $speaking_participant_1_name = $row["speaking_participant_1_name"];
                $speaking_participant_1_email = $row["speaking_participant_1_email"];
            }
        ?>
        <div class="container">
            <form action="backend/team.php" method="post">
                <fieldset>
                    <h1>
                        Team
                    </h1>
                    <p>
                        <?php
                            if (isset($_GET["updated"])) {
                                echo "<strong>Your team details have been updated. </strong>";
                            }
                        ?><span style="color: #aaa">Please note that a student may only participate in one event.</span>
                    </p>
                    <h3>Design</h3>
                    <p>
                        <label for="design_participant_1_name">Participant 1:</label>
                        <input name="design_participant_1_name" id="design_participant_1_name" type="text" value="<?php echo $design_participant_1_name; ?>" placeholder="Enter participant's name">
                        <input name="design_participant_1_email" type="email" value="<?php echo $design_participant_1_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <label for="design_participant_2_name">Participant 2:</label>
                        <input name="design_participant_2_name" id="design_participant_2_name" type="text" value="<?php echo $design_participant_2_name; ?>" placeholder="Enter participant's name">
                        <input name="design_participant_2_email" type="email" value="<?php echo $design_participant_2_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <label for="design_participant_3_name">Participant 3:</label>
                        <input name="design_participant_3_name" id="design_participant_3_name" type="text" value="<?php echo $design_participant_3_name; ?>" placeholder="Enter participant's name">
                        <input name="design_participant_3_email" type="email" value="<?php echo $design_participant_3_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <h3>Programming</h3>
                    <p>
                        <label for="programming_participant_1_name">Participant 1:</label>
                        <input name="programming_participant_1_name" id="programming_participant_1_name" type="text" value="<?php echo $programming_participant_1_name; ?>" placeholder="Enter participant's name">
                        <input name="programming_participant_1_email" type="email" value="<?php echo $programming_participant_1_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <label for="programming_participant_2_name">Participant 2:</label>
                        <input name="programming_participant_2_name" id="programming_participant_2_name" type="text" value="<?php echo $programming_participant_2_name; ?>" placeholder="Enter participant's name">
                        <input name="programming_participant_2_email" type="email" value="<?php echo $programming_participant_2_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <h3>Quiz</h3>
                    <p>
                        <label for="quiz_participant_1_name">Participant 1:</label>
                        <input name="quiz_participant_1_name" id="quiz_participant_1_name" type="text" value="<?php echo $quiz_participant_1_name; ?>" placeholder="Enter participant's name">
                        <input name="quiz_participant_1_email" type="email" value="<?php echo $quiz_participant_1_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <label for="quiz_participant_2_name">Participant 2:</label>
                        <input name="quiz_participant_2_name" id="quiz_participant_2_name" type="text" value="<?php echo $quiz_participant_2_name; ?>" placeholder="Enter participant's name">
                        <input name="quiz_participant_2_email" type="email" value="<?php echo $quiz_participant_2_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <h3>Gaming</h3>
                    <p>
                        <label for="gaming_participant_1_name">Participant 1:</label>
                        <input name="gaming_participant_1_name" id="gaming_participant_1_name" type="text" value="<?php echo $gaming_participant_1_name; ?>" placeholder="Enter participant's name">
                        <input name="gaming_participant_1_email" type="email" value="<?php echo $gaming_participant_1_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <label for="gaming_participant_2_name">Participant 2:</label>
                        <input name="gaming_participant_2_name" id="gaming_participant_2_name" type="text" value="<?php echo $gaming_participant_2_name; ?>" placeholder="Enter participant's name">
                        <input name="gaming_participant_2_email" type="email" value="<?php echo $gaming_participant_2_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <h3>Speaking</h3>
                    <p>
                        <label for="speaking_participant_1_name">Participant 1:</label>
                        <input name="speaking_participant_1_name" id="speaking_participant_1_name" type="text" value="<?php echo $speaking_participant_1_name; ?>" placeholder="Enter participant's name">
                        <input name="speaking_participant_1_email" type="email" value="<?php echo $speaking_participant_1_email; ?>" placeholder="Enter participant's email" style="margin-top: 10px">
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
                        <input type="submit" value="Save Team Details">
                    </p>
                </fieldset>
            </form>
        </div>
        <?php include "backend/footer.php"; ?>
    </body>
</html>

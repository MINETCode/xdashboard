<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
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
    function _ago($tm, $rcs = 0) {
        $cur_tm = time(); $dif = $cur_tm-$tm;
        $pds = array('second','minute','hour','day','week','month','year','decade');
        $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
        for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

        $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
        if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
        return $x;
    }
?><!doctype html>
<html>
    <head>
        <title>X</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="big">
        <p style="margin: 400px">Thank you for your RSVP. We&rsquo;ll keep in touch.</p>
    </body>
</html>

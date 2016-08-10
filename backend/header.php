<title><?php
    if (ucfirst(str_replace(".php", "", substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1))) == "Index") {
        echo "Dashboard &middot; X 2016";
    } else {
        echo ucfirst(str_replace(".php", "", substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1)));
        echo " &middot; X 2016";
    }
?></title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="img/icon.png">
<link rel="apple-touch-icon-precomposed" href="img/icon.png">
<meta name="theme-color" content="#2979ff">

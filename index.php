<?php
session_start();
//require_once ('php/home.php');
?>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="https://cdn.iconscout.com/icon/free/png-256/teeth-2-129390.png">
        <title>FogOrvosiRendelo</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <!--Navigációs menü-->
        <div class="sidenav" id="nav">
            <a class="nav_item" href="php/home.php">Kezdőlap</a>
            <a class="nav_item" id="nav_patient" href="php/patient.php">Adatlap</a>
            <a class="nav_item" id="nav_visits" href="php/visits.php">Kórtörténet</a>
            <?php
            if (!isset($_SESSION['id'])) {
                echo '<button class="dropdown-btn nav_item" >Bejelentkezés<i class="fa fa-caret-down"></i></button>' .
                '<div class="dropdown-container">' .
                '<form  class="login_nav" action="php/login.php" method="post">' .
                '<input class="nav_item_box" type="text" placeholder="Felhasználóinév" name="username" required/>' .
                '<input class="nav_item_box" type="password" placeholder="Jelszó" name="password" required/>' .
                '<input class="nav_item" type="submit" name="enter" value="Belépés">' .
                '</form>' .
                '</div>';
            } else {
                echo '<a class="nav_item" id="nav_logout" href="php/logout.php">Kijelentkezés</a>';
                echo '<a class="nav_item" id="nav_change" href="php/change_webdata.php">Belépési Adatok módosítás</a>';
            }
            ?>
        </div> 
        <!--Maga az oldal-->
        <div class="main_content">
            <?php
            if (isset($_SESSION['unauthorized']) && $_SESSION['unauthorized']) {
                $error = file_get_contents('html/unauthorized.html');
                echo $error;
                unset($_SESSION['unauthorized']);
            }
            if (isset($_SESSION['id']) /* && isset($_SESSION['patient']) */) {
                echo $_SESSION['set_page'];
            } else {
                echo $_SESSION['home'];
                die();
            }
            ?>
            <img src="pics/t-heart.jpg" alt='heart' width="20px" height="20px">
        </div>
    </body>
</html>

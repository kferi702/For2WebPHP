<?php
session_start();
$home=file_get_contents('../html/home_1.html');
$home.=file_get_contents('../html/home_opening.html');
$home.=file_get_contents('../html/home_services.html');


$_SESSION['set_page']=$_SESSION['home']=$home;
header('Location: ../index.php');
<?php
session_start();
$home="A kezdőlap main része";
$_SESSION['set_page']=$_SESSION['home']=$home;
header('Location: ../index.php');


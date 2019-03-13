<?php
session_start();
require_once ('..//config/unauthorized.php');

if(isset($_SESSION['id'])){
$id=$_SESSION['id'];

$visits="Üzenetek";

$_SESSION['set_page']=$_SESSION['visits']=$visits;
header('Location: ../index.php');
}else{
    header('Location: ../index.php');
    die();
}

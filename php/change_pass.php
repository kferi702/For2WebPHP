<?php
session_start();
require_once ('..//config/unauthorized.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $change_pass="Jelszó Módosítása!";
    $_SESSION['set_page'] = $_SESSION['change_pass'] = $change_pass;
    header('Location: ../index.php');
}else {
    header('Location: ../index.php');
    die();
}
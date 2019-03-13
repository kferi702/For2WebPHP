<?php

require_once('../config/connect.php');
if(!isset($_SESSION['id'])){
    $_SESSION['unauthorized']=true;
    header('Location: ../index.php');
    die();
}


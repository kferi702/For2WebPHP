<?php
session_start();
require_once ('..//config/connect.php');
if (isset($_POST['saveTable'])){
    $id=$_SESSION['id'];
    $b_name=$_POST['b_name'];
    $m_name=$_POST['m_name'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $sql="UPDATE patient_sec "
            . "SET birth_name=?, mother_name=?, address=?, phone=?, email=? "
            . "WHERE patient_id=?;";
    $stmt=$connection->prepare($sql);
    $stmt -> bind_param('ssssss',$b_name,$m_name,$address,$phone,$email,$id);
    $stmt -> execute();
    $stmt -> close();
    $_SESSION['saveStatus']="Az adatok módisítása sikeresen megtörténet!";
    header('Location: ../index.php');
}else{
    $_SESSION['saveStatus']="Az adatok nem lettek módosítva!";
    header('Location: ../index.php');
    die();
}


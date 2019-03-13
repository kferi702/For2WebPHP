<?php

session_start();
require_once ('..//config/connect.php');
if (isset($_POST['enter'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql="SELECT password "
            . "FROM patient_web "
            . "WHERE username=?;";
      $stmt =$connection->prepare($sql);
      $stmt -> bind_param("s", $username);
      $stmt -> execute();
      $stmt -> bind_result($hash_pass);
      $stmt -> fetch();
      $stmt->close();
    if (password_verify($password,$hash_pass)) {
        //Sikeresen bejelentkezés
        $username = $_POST['username'];
        $sqlSelId="SELECT patient_id "
            . "FROM patient_web "
            . "WHERE username=?;";
        $stmt =$connection->prepare($sqlSelId);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $_SESSION['id']=$id;
        header('location: ../index.php');
    } else {
        header('location: ../index.php');
        $_SESSION['hibás_login']="Hibás bejelentekzési adatok!";
    }

        
    
    $stmt->close();
    $connection->close();
}
   


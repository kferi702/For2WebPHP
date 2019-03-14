<?php

session_start();
require_once ('..//config/unauthorized.php');
if (isset($_SESSION['id']))  
    {
    $id = $_SESSION['id'];
    $patient = "Azonosítószám " . $id . "";

    $sql = "SELECT patient.name, " .
            "patient_sec.birth_name, " .
            "patient.tb, " .
            "patient.birthdate, " .
            "patient_sec.birthplace, " .
            "patient_sec.mother_name, " .
            "patient_sec.address, " .
            "patient_sec.phone, " .
            "patient_sec.email " .
            "FROM patient, patient_sec " .
            "WHERE patient_id=? " .
            "AND patient.id=patient_sec.patient_id;";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $b_name = $row['birth_name'];
        $tb = $row['tb'];
        $b_date = $row['birthdate'];
        $b_place = $row['birthplace'];
        $m_name = $row['mothername'];
        $address = $row['address'];
        $phone = $row['phone'];
        $email = $row['email'];
        $table = "<form action='php/saveTable.php' method='post'>"
                . "<table id='pat_table'>"
                . "<tr>"
                . "<td id='tn'>Név</td>"
                . "<td id='tv'>" .$name. "</td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>Születési név</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $b_name . "' "
                . "placeholder='" .$b_name. "' name='b_name'></td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>TB szám</td>"
                . "<td id='tv'>" . $tb. "</td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>Születési idő</td>"
                . "<td id='tv'>" . $b_date. "</td>"
                . "<Ztr>"
                . "<tr>"
                . "<td id='tn'>Anyja neve</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $m_name . "' "
                . "placeholder='" . $m_name . "' name='m_name' required></td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>Lakcím</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $address . "' "
                . "placeholder='".$$address."'name='address' required></td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>Telefonszám</td>"
                . "<td id='tv'>"
                . "<input type='text' value='".$phone."'"
                . "placeholder='".$phone."'name='phone' required></td>"
                . "</tr>"
                . "<tr>"
                . "<td id='tn'>E-mail cím</td>"
                . "<td id='tv'>"
                . "<input type='text'value='".$email."' "
                . "placeholder='".$email."'name='email'></td>"
                . "</tr>"
                . "<tr>"
                . "<td colspan='2'><input type='submit' name='saveTable' value='Módosítások mentése'><td>"
                . "</tr>"
                . "</table>"
                . "</form>";
    }
    $stmt->close();
    
    
    $_SESSION['set_page']=$_SESSION['patient'] = $table;
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
    die();
}






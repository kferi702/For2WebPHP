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
                . "<table>"
                . "<tr>"
                . "<td id='tn'>Név</td>"
                . "<td id='tv'>" . $row['name'] . "</td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>Születési név</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $row['birth_name'] . "' "
                . "placeholder='" . $row['birth_name'] . "' name='b_name'></td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>TB szám</td>"
                . "<td id='tv'>" . $row['tb'] . "</td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>Születési idő</td>"
                . "<td id='tv'>" . $row['birthdate'] . "</td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>Anyja neve</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $row['mothername'] . "' "
                . "placeholder='" . $row['mothername'] . "' name='m_name' required></td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>Lakcím</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $row['address'] . "' "
                . "placeholder='" . $row['address'] . "' name='address' required></td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>Telefonszám</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $row['phone'] . "' "
                . "placeholder='" . $row['phone'] . "' name='phone' required></td>"
                . "<tr>"
                . "<tr>"
                . "<td id='tn'>E-mail cím</td>"
                . "<td id='tv'>"
                . "<input type='text' value='". $row['email'] . "' "
                . "placeholder='" . $row['email'] . "' name='email'></td>"
                . "<tr>"
                . "</table>"
                . "<input type='submit' name='saveTable' value='Módosítások mentése'>"
                . "</form>";
    }
    $stmt->close();
    
    
    $_SESSION['set_page']=$_SESSION['patient'] = $table;
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
    die();
}






<?php

session_start();
require_once ('..//config/unauthorized.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT date, text "
            . "FROM patient_visits "
            . "WHERE patient_id=? ;";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $visits = "<p>Megtekintheti a korábbi látogatásinak a kórtörténetét, ha esetleges kérdése merülne fel bizalommal forduljon kezelő fogorvosához!</p>";
    
    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $text = $row['text'];

        $visits .= "<p id='visits'>"
                . $date . ":"
                . "<br>"
                . "<q id='vis_text'>"
                . $text
                . "</q>"
                . "</p>";
        $visits .= "<div class='parallax'></div>";
       
    }
    $stmt->close();
    
    $_SESSION['set_page'] = $_SESSION['visits'] = $visits;
    header('Location: ../index.php');
} else {
    header('Location: ../index.php');
    die();
}

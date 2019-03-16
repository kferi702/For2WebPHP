<?php

session_start();
require_once ('..//config/unauthorized.php');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT date, text, staff.name "
            . "FROM patient_visits, staff "
            . "WHERE staff_id=staff.id "
            . "AND patient_id=? ;";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $visits = "<div id='visits-first-box'><h2>Kórtörénet:</h2><p>Itt megtekintheti a korábbi látogatásinak a kórtörténetét, ha esetleges kérdése merülne fel bizalommal forduljon kezelő fogorvosához! Amennyiben nem jelenne meg egy darab sem azesetben vagy nem volt még egy kezelése sem vagy probléma lépett fel a rendszerben és kérjük próbálkozzon késöbb újra. </p></div>";
    
    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $text = $row['text'];
        $staff = $row['name'];

        $visits .= "<p id='visits'>"
                . ""
                . $date ."<br>". $staff.":"
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

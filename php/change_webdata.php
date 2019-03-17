<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<?php
session_start();
require_once ('..//config/unauthorized.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT username "
            . "FROM patient_web "
            . "WHERE patient_id=?;";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
    //változás jelölő doboz
    $change_webdata_changebox = "<div class='changebox' id='change_webdata_changebox'>Események: ";
    //első doboz
    $change_webdata_firstbox = file_get_contents('../html/change_webdata_welcome_box.html');
    //második doboz
    $change_webdata_secondbox = "<form class='changebox' id='change_webdata_secondbox' "
            . "action='php/change_webdata.php' method='post'>"
            . "<table id='table_webdata'>"
            . "<tr>"
            . "<td>Jelenlegi felhasználói neve: </td>"
            . "<td>"
            . $username
            . "</td>"
            . "</tr>"
            . "<tr>"
            . "<td>Új felhasználói neve:</td>"
            . "<td><input id='tab_w_text_box_un' type='text' name='unnew' required/></td>"
            . "</tr>"
            . "<tr>"
            . "<td>Új felhasználói neve ismét:</td>"
            . "<td><input id='tab_w_text_box_un' type='text' name='unconf' required/></td>"
            . "</tr>"
            . "<tr>"
            . "<td colspan='2'><input id='table_webdata_button'type='submit' name='new_name' value='Felhasználói név módisítása'/></td>"
            . "</tr>"
            . "</table>"
            . "</form>";
    //harmadik doboz
    $change_webdata_thirdbox = "<form class='changebox' id='change_webdata_thirdbox' "
            . "action='php/change_webdata.php' method='post'>"
            . "<table id='table_webdata'>"
            . "<tr>"
            . "<td>Jelenlegi jelszó:</td>"
            . "<td><input id='tab_w_text_box_pw' type='text' name='pwold' required/><br></td>"
            . "</tr>"
            . "<tr>"
            . "<td>Új jelszó:</td>"
            . "<td><input id='tab_w_text_box_pw' type='text' name='pwnew' required/><br></td>"
            . "</tr>"
            . "<tr>"
            . "<td>Új jelszó mégegyszer:</td>"
            . "<td><input id='tab_w_text_box_pw' type='text' name='pwconf' required/><br></td>"
            . "</tr>"
            . "<tr>"
            . "<td colspan='2'><input id='table_webdata_button' type='submit' name='new_pass' value='Jelszó módosítás'/></td>"
            . "</table>"
            . "</form>";
    if (isset($_POST['new_name'])) {
        $un_new = $_POST['unnew'];
        $un_conf = $_POST['unconf'];
        if ($un_new != "" && $un_conf != "") {
            if ($un_new == $un_conf) {
                if ($username != $un_new) {
                    $sql = "SELECT COUNT(*) FROM patient_web WHERE username=?;";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("s", $un_new);
                    $stmt->execute();
                    $stmt->bind_result($exist);
                    $stmt->fetch();
                    $stmt->close();
                    if ($exist == 0) {
                        $sql = "UPDATE patient_web SET username=? WHERE patient_id=?;";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("ss", $un_new, $id);
                        $stmt->execute();
                        $stmt->close();
                        $change_webdata_changebox .= "A felhasználói név módosítása sikeresen megtörtént!";
                    } else {
                        $change_webdata_changebox .= "A új választott felhasználói név már foglalt!";
                    }
                } else {
                    $change_webdata_changebox .= "Az új felhasználói név nem lehet ugyanaz mint a jelenlegi felhasználóinév!";
                }
            } else {
                $change_webdata_changebox .= "A két felhasználói név nem egyforma!" . $un_new . "-" . $un_conf;
            }
        } else {
            $change_webdata_changebox .= "Mindkét felhasználói név mezőt kikell tölteni!";
        }
    }
    if (isset($_POST['new_pass'])) {
        $pw_old = $_POST['pwold'];
        $pw_new = $_POST['pwnew'];
        $pw_conf = $_POST['pwconf'];
        if ($pw_old != "" && $pw_new != "" && $pw_conf != "") {
            if ($pw_new == $pw_conf) {
                if ($pw_new != $pw_old) {
                    $sql = "SELECT password "
                            . "FROM patient_web "
                            . "WHERE patient_id=?;";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("s", $id);
                    $stmt->execute();
                    $stmt->bind_result($hash_pass);
                    $stmt->fetch();
                    $stmt->close();
                    if (password_verify($pw_old, $hash_pass)) {
                        $sql = "UPDATE patient_web SET password=?  WHERE patient_id=?;";
                        $stmt = $connection->prepare($sql);
                        $hash = password_hash($pw_new, PASSWORD_BCRYPT);
                        $stmt->bind_param("ss", $hash, $id);
                        $stmt->execute();
                        $stmt->close();
                        $change_webdata_changebox .= "Jelszó Módosítás sikeresen megtörtént!";
                    } else {
                        $change_webdata_changebox .= "Hiba az új jelszó elmentés közben!";
                    }
                } else {
                    $change_webdata_changebox .= "A régi és az új jelszó nem lehet ugyanaz!";
                }
            } else {
                $change_webdata_changebox .= "Az új jelszavak nem egyeznek meg";
            }
        } else {
            $change_webdata_changebox .= "Mind a három mező kitölrése kötelező!";
        }
    }

    $change_webdata_changebox .= "</div>";
    $_SESSION['set_page'] = $_SESSION['change_pass'] = $change_webdata_firstbox . $change_webdata_changebox . $change_webdata_secondbox . $change_webdata_thirdbox;
    header('Location: ../index.php');
} else {
    $change_pass = "valami hiba????";
    $_SESSION['set_page'] = $_SESSION['change_pass'] = $change_pass;
    header('Location: ../index.php');
    die();
}
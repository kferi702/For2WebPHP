<?php
session_start();
echo file_get_contents('html/head.html');
            if (!isset($_SESSION['id'])) {
                echo file_get_contents('html/logged_out.html');
            } else {
                echo file_get_contents('html/logged_in.html');
            }
            if (isset($_SESSION['unauthorized']) && $_SESSION['unauthorized']) {
                $error = file_get_contents('html/unauthorized.html');
                echo $error;
                unset($_SESSION['unauthorized']);
            }
            if (isset($_SESSION['id']) /* && isset($_SESSION['patient']) */) {
                echo $_SESSION['set_page'];
            } else {
                echo $_SESSION['home'];
                die();
            }
echo file_get_contents('html/site_end.html');            
?>          
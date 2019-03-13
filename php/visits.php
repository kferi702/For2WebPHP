<head> 
    <script type="text/javascript" src="../js/script.js"></script>
</head>
<?php
session_start();
require_once ('..//config/unauthorized.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $ar = array();
    $i = 1;
    $mappa = scandir('28');
    $p_path= $_SERVER["PHP_SELF"];
    foreach ($mappa as $x) {
        if (in_array($x, array('..', '.'))) {
            continue;
        }
        if (is_dir($x)) {
            $ar[$x] = scandir($x);
        } else {
            $ar[] = $x;
        }
    }
    echo sizeof($ar).'<br>';
    $sor=0;
    for ($k = 0; $k < sizeof($ar); $k++) {
        $path='file:///E:/xampp/htdocs/FogOrvosiRendelo2/'.$id.'/'.$ar[$k];
        $myfile = fopen($path, "r") or die("Fájl nme nyitható meg!");
        echo fread($myfile, filesize($path)).'<br>';
        echo $sor;
        $sor++;
        fclose($myfile);
    }

    $visits="<selector";
    
//$_SESSION['set_page']=$_SESSION['visits']=$visits;
//header('Location: ../index.php');
} else {
    header('Location: ../index.php');
    die();
}

<?php
require_once('../database.php');
require_once('../auth.php');


if(isset($_POST['register'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    if($dbAccess->verificaPresenza($_POST['username'], $_POST['mail'])){
        $_SESSION["error"] = 'Nome Utente o mail già occupati';
        header("location:register.php");
    }
    else{
        $dbAccess->inserisciUtente($_POST['username'],$_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date'], $_POST['address'], $_POST['city'], $_POST['mail']);
        $_SESSION["username"] = $_POST['username'];
        $_SESSION["credito"] = "100";
        header("location:../../");
    }
    $dbAccess->closeDBConnection();
}
else{      
        if(isset($_SESSION["error"])){
            $error = $_SESSION["error"];
            echo '<script language="javascript">';
            echo "alert('Nome utente o mail già presenti nel database')";
            echo '</script>';
            unset($_SESSION["error"]);
        }
        
        if(isset($_SESSION['username'])){
            header('Location: ../../');
        }
}

$pagina = areaAutenticazione(file_get_contents('../../html/autenticazione/register.html'));
echo $pagina;

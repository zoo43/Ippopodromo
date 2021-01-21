<?php
require_once('../database.php');

session_Start();

if(isset($_POST['register'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    if($dbAccess->verificaPresenza($_POST['username'], $_POST['mail'])){
        $_SESSION["error"] = 'Nome Utente o mail già occupati';
        header("location:register.php");
    }
    else{
        $dbAccess->inserisciUtente($_POST['username'],$_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date'], $_POST['address'], $_POST['city'], $_POST['mail']);
        echo "Sei registrato!";
    }
    $dbAccess->closeDBConnection();
}
?>
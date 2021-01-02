<?php
require_once('database.php');

session_Start();


if(isset($_POST['login'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    if($dbAccess->autentica($_POST['username'], $_POST['password'])){
        echo "ci sei!";
    }
    else{
        $_SESSION["error"] = 'Nome Utente o password errati';
        header("location:login.php");
    }
    $dbAccess->closeDBConnection();
}
?>
<?php
require_once('../database.php');

session_Start();

if(isset($_POST['register'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
	if($conn)
	{
    $username = $_POST['username'];
    if($dbAccess->verificaPresenza($username, $_POST['mail'])){
        $_SESSION["error"] = 'Nome Utente o mail già occupati';
        header("location:register.php");
    }
    else{
        $dbAccess->inserisciUtente($username,$_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date'], $_POST['address'], $_POST['city'], $_POST['mail']);
        $_SESSION["username"] = $username;
        $_SESSION["credito"] = "100";
        header("location:../../");
    }
	}
	else
	{
		printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
	}
	$dbAccess->closeDBConnection();
}
?>
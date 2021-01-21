<?php

require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);

unset($_SESSION["cavalli"]);
unset($_SESSION['idGara']);
echo "//Pulsante per tornare indietro";
$dbAccess->closeDBConnection();


?>
<?php
require_once('../database.php');
session_Start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);

unset($_SESSION["cavalli"]);
unset($_SESSION['idGara']);
echo "//Pulsante per tornare indietro";
$dbAccess->closeDBConnection();


?>
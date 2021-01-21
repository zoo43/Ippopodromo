<?php

require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);

if($dbAccess->confermaScommesse($_SESSION['idGara']))
{
	echo '<script type="text/javascript">';
			echo 'alert("L\'inserimento è andato a buon fine")';
			echo '</script>';
}
else
{
	echo '<script type="text/javascript">';
			echo 'alert("Si è verificato un errore imprevisto. Si prega di attendere prima di riprovare.")';
			echo '</script>';
}
unset($_SESSION["cavalli"]);
unset($_SESSION['idGara']);
echo "//Pulsante per tornare indietro";
$dbAccess->closeDBConnection();


?>
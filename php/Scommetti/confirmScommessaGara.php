<?php
require_once('../database.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

session_Start();

if($conn)
{
	if(isset($_SESSION["username"]))
	{
		echo "Gara Numero: ".$_POST['idGara']."<br />";
		echo "Ora Gara: ".$_POST['dataGara']."<br />";
		$row = $dbAccess->getInfoCavallo($_POST['cavallo'], Null);
		$nomeCavallo = mysqli_fetch_array($row)["nome"];
		echo "Cavallo puntato: ".nomeCavallo."<br />";
		echo "Valore puntata: ".$_POST['scommessa']."<br />";
		echo '<input type="submit" onclick=""> Conferma </button>';
		echo '<input type="submit" onclick=""> Annulla </button>';
	}
	$dbAccess->closeDBConnection();
}
?>

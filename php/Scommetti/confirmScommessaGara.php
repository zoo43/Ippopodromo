<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if($conn)
{
	if(isset($_SESSION["username"]))
	{
		echo '<form method="post" action="checkScommessaGara.php">'; 
		echo "Gara Numero: ".$_POST['idGara']."<br />";
		echo "Ora Gara: ".$_POST['dataGara']."<br />";
		$row = $dbAccess->getInfoCavallo($_POST['cavallo'], Null);
		$nomeCavallo = mysqli_fetch_array($row)["nome"];
		echo "Cavallo puntato: ".$nomeCavallo."<br />";
		echo "Valore puntata: ".$_POST['scommessa']."<br />";
		
		echo '<input type="hidden" name="numeroGara" value="'.$_POST['idGara'].'">';
		echo '<input type="hidden" name="numeroCavallo" value="'.$_POST['cavallo'].'">';
		echo '<input type="hidden" name="valorePuntata" value="'.$_POST['scommessa'].'">';
		
		echo '<input type="submit" name="confermaScommessa" value="Conferma" />';
		echo '</form>';
		echo '<input type="button" onclick="window.location.href=\'scommetti.php\'" value="Annulla" />';
	}
	$dbAccess->closeDBConnection();
}
?>

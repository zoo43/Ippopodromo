<?php 
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn)
{
	if(isset($_SESSION['username']))
	{
		$userResult = $dbAccess->getScommesseUtente($_SESSION['username']);
		if($userResult)
		{
			while($row = mysqli_fetch_array($userResult))
			{
				print("Numero gara: ".$row['idGara']."<br />") ;
				print("Data gara: ".$row['dataGara']."<br />");
				print("Cavallo puntato: <a href='../visualizzazione_Cavalli/cavalloSelezionato.php?value=".$row['idCavallo']."'>".$row['nome']."</a> <br />");
				print("Valore puntata: ".$row['puntata']."<br />");
				print("<br />");
			}
		}
	}
	$dbAccess->closeDBConnection();
	echo "<p><a href='scommetti.php'> Torna indietro </a></p>";
}
?>
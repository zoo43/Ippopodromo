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
				if($row['stato']=='1')
				{
					$result = $dbAccess->getPosizioneCavalloScommessa($row['idGara'], $row['idCavallo']);
					$posizione = mysqli_fetch_array($result);
					if($posizione['posizione'] == '1')
					{
						echo "Risultati gara: hai vinto <br />";
					}
					else
					{
						echo "Risultati gara: hai perso <br />";
					}
					mysqli_free_result($result);
				}else
				{
					echo "Risultati gara: risultati non ancora pubblicati <br />";
				}
				print("<br />");
			}
		}
		mysqli_free_result($userResult);
		
	}
	$dbAccess->closeDBConnection();
	echo "<p><a href='scommetti.php'> Torna indietro </a></p>";
}
?>
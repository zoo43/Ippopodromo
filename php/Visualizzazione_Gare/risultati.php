<?php
require_once('../database.php');


$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
$result = $dbAccess->getRisultati("2");
while($row = mysqli_fetch_array($result))
{          
    echo "<p><a href='garaSelezionata.php?value=". $row['idGara'] ."'>Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</a></p>"; "<br />";
}
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";
?>
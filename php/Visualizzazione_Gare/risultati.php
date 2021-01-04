<?php
require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
$result = $dbAccess->getRisultati();
while($row = mysqli_fetch_array($result))
{          
    echo "<p><a href='garaSelezionata.php?value=". $row['idGara'] ."'>Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</a></p>"; "<br>";                                                             
}

$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";
?>
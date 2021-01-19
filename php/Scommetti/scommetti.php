<?php
require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    echo $username . " Credito:" . $credito;
    $result = $dbAccess->getGare("0");
    while($row = mysqli_fetch_array($result))
    {          
        echo "<p>" . "Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</p>";  
		echo "<p><a href='garaScommessa.php?value=".$row['idGara']."'>Scommetti sulla gara</p></a>";
    }
    mysqli_free_result($result);
	
	echo "<p><a href='scommesseUtente.php'>Visualizza le tue scommesse</a></p>";
}
else
{
    echo "Accedi per poter scommettere";
}
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";
?>
<?php
require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if(isset($_POST['register']))
{
    if($conn)
    {
    $dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);
    unset($_SESSION["cavalli"]);
    unset($_SESSION['idGara']);
    echo "//Pulsante per tornare indietro";
    }
    else
    {
        echo "problema connessione al DB";
    }
}
else
{
if($conn)
{
$result = $dbAccess->getGare("0");
while($row = mysqli_fetch_array($result))
{          
    echo "<p><a href='inserisciRisultati.php?value=". $row['idGara'] ."'>Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</a></p>"; "<br />";
}
mysqli_free_result($result);
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
}


$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";
?>
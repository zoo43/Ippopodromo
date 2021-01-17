<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 
     

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
$result=$dbAccess->getInfoGara($params['value']);

echo "<p>Classifica:</p>";
echo "<p>Posizione Cavallo </p>";
while($row = mysqli_fetch_array($result))
{
    $data = $row['dataGara'];
    echo "<p> ". $row['posizione'] . " " . $row['nome'] . "</p>" ;
}
echo "<p>Gara svoltasi in data: " . $data . "</p>";
mysqli_free_result($result);
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess ->closeDBConnection();
echo "<p><a href='risultati.php'> Torna indietro </a></p>";
?>
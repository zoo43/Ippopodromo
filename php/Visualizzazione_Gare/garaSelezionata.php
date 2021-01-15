<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 
     

$dbAccess = new DBAccess();
if($dbAccess->openDBConnection())
{
$result=$dbAccess->getInfoGara($params['value']);

echo "<p>Classifica:</p>";
echo "<p>Posizione Cavallo </p>";
while($row = mysqli_fetch_array($result))
{
    $data = $row['dataGara'];
    echo "<p> ". $row['posizione'] . " " . $row['idCavallo'] . "</p>" ;
}
echo "<p>Gara svoltasi in data: " . $data . "</p>";
$dbAccess->closeDBConnection();
}

echo "<p><a href='risultati.php'> Torna indietro </a></p>";
?>
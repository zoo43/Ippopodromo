<?php
require_once('database.php');
 $url = $_SERVER['REQUEST_URI'];    
 $url_components = parse_url($url); 
 parse_str($url_components['query'], $params); 
      

 $dbAccess = new DBAccess();
 $conn = $dbAccess->openDBConnection();
 $result=$dbAccess->getInfoCavallo($params['value']);


 while($row = mysqli_fetch_array($result))
{
    $id = $row['idCavallo'];
    $descrizione = $row['descrizione'];
    print  "data: " . $row['dataGara'] . " posizione: " . $row['posizione']; 
    echo "<br>";
}

//Immagine
$immagine;
echo "Nome cavallo:" . $id . "," . $descrizione . "///Sto pezzo qua con il css va messo sopra o in qualche posto bello con img";

 $dbAccess->closeDBConnection();
?>
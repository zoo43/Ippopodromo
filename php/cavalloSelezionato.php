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
    $immagine = $row['immagine'];
    $descrizione = $row['descrizione'];
    print  "data: " . $row['dataGara'] . " posizione: " . $row['posizione']; 
    echo "<br>";
}


echo "Nome cavallo:" . $id . "," . $descrizione ."<img src='../$immagine' alt='Immagine del cavallo $id'>";
echo "<br>";
echo "<p><a href='cavalli.php'> Torna indietro </a></p>";
 $dbAccess->closeDBConnection();
?>
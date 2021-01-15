<?php
require_once('../database.php');
 $url = $_SERVER['REQUEST_URI'];    
 $url_components = parse_url($url); 
 parse_str($url_components['query'], $params); 

 $dbAccess = new DBAccess();
 $conn = $dbAccess->openDBConnection();
 if($conn)
 {
 $result=$dbAccess->getInfoCavallo($params['value']);
 
 while($row = mysqli_fetch_array($result))
{
    $id = $row['idCavallo'];
    $nome = $row['nome'];
    $immagine = $row['immagine'];
    $descrizione = $row['descrizione'];
    print  "data: " . $row['dataGara'] . " posizione: " . $row['posizione']; 
    echo "<br />";
}

echo "$nome ," . $descrizione ."<img src='../../images/$immagine' alt='Immagine del cavallo $id'>";
echo "<br />";
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='cavalli.php'> Torna indietro </a></p>";
?>
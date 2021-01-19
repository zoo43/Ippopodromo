<?php
require_once('../database.php');
 $url = $_SERVER['REQUEST_URI'];    
 $url_components = parse_url($url); 
 parse_str($url_components['query'], $params); 

 $dbAccess = new DBAccess();
 $conn = $dbAccess->openDBConnection();
 if($conn)
 {
 $result=$dbAccess->getInfoCavallo($params['value'],true);
 
if($result)
{ 
    while($row = mysqli_fetch_array($result))
    {    
        $id = $row['idCavallo'];
        $nome = $row['nome'];
        $immagine = $row['immagine'];
        $descrizione = $row['descrizione'];
        print  "data: " . $row['dataGara'] . " posizione: " . $row['posizione']; 
        echo "<br />";
    }
    echo "<p>$nome," . $descrizione ."<img src='../../images/$immagine' alt='Immagine del cavallo $nome'</p>";
}
else
{
    $result=$dbAccess->getInfoCavallo($params['value'],false);
    $row = mysqli_fetch_array($result);
    echo "<p>" .$row['nome'] ." , ". $row['descrizione'] ."<img src='../../images/".$row['immagine'] ."' alt='Immagine del cavallo ".$row['nome'] . "' </p>";
    echo "Questo cavallo non ha ancora partecipato a nessuna gara";
    echo "<br />";
}
mysqli_free_result($result);
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='javascript:history.back()'>Torna indietro</a></p>";


?>
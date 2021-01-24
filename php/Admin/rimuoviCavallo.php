<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if($conn)
{
    $path =$dbAccess->eliminaCavallo($params['value']);
    if($path != false){
        echo "$path";
        unlink("../../images/$path");
        echo "cavallo eliminato con successo";
    }
    else
    {
        echo "problema nel dialogo con il db (il cavallo potrebbe partecipare una gara e sarebbe quindi impossibile da eliminare)";
    }
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
?>
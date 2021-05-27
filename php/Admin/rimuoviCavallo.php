<?php
require_once('../database.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if($conn)
{
   
    if( $dbAccess->eliminaCavallo($params['value'])){
        echo "cavallo ritirato con successo";
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
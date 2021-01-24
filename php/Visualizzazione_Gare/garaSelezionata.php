<?php
require_once('../database.php');
require_once('../auth.php');

$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
$classifica='';
$giorno='';
$ora='';

if($conn)
{
$result=$dbAccess->getInfoGara($params['value']);

while($row = mysqli_fetch_array($result))
{
    $arr=explode(" ",$row['dataGara']);
    $giorno = $arr[0];
    $ora = $arr[1];
    $classifica .= '<tr>
    					<td><a href="../Visualizzazione_Cavalli/cavalloSelezionato.php?value='. $row["idCavallo"] .'"> '. $row['posizione'] . ' ' . $row['nome'] . ' </a></td> 
    				</tr>';
}

mysqli_free_result($result);
}
else
{
	$classifica .= '<tr>
    					<td>Errore dio connessione</td> 
    				</tr>';
}

$dbAccess ->closeDBConnection();
$pagina = file_get_contents('../../html/gare/garaSelezionata.html');
$pagina = str_replace(
    array("<classifica />", "<giorno />", "<ora />"),
    array($classifica, $giorno, $ora),
    $pagina
);
$pagina = areaAutenticazione($pagina);

echo $pagina;
?>
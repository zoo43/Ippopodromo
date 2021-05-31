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
$id=$params['value'];

if($conn)
{
$result=$dbAccess->getInfoGara($params['value']);

while($row = mysqli_fetch_array($result))
{
    $arr=explode(" ",str_replace('-','/', $row["dataGara"]) );
    $giorno = $arr[0];
    $ora = $arr[1];
    // $classifica .= '<tr>
    // 					<td><a href="../cavalli/cavalloSelezionato.php?value='. $row["idCavallo"] .'"> '. $row['posizione'] . ' ' . $row['nome'] . ' </a></td>
    // 				</tr>';

    $classifica .= '<li>
    					<a href="../cavalli/cavalloSelezionato.php?value='. $row["idCavallo"] .'"> ' . $row['nome'] . '</a>
    				</li>';
}

mysqli_free_result($result);
}
else
{
	$classifica .= '<li>
    					Errore di connessione
    				</li>';
}

$dbAccess ->closeDBConnection();
$pagina = file_get_contents('../../html/gare/garaSelezionata.html');
$pagina = str_replace(
    array("<classifica />", "<giorno />", "<ora />", "<id-gara />"),
    array($classifica, $giorno, $ora, $id),
    $pagina
);
$pagina = areaAutenticazione($pagina);

echo $pagina;
?>

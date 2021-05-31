<?php
require_once('../database.php');
require_once('../auth.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}


$gare = '<table><caption>Gare ancora aperte</caption><thead><tr><th>ID gara</th><th>Data</th><th>Opzioni</th></tr></thead><tbody>';
$selezione = '';
$risultatoInserimento='';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if ($conn) {
    $result = $dbAccess->getGare("0");
    while ($row = mysqli_fetch_array($result)) {
        $gare .= '<tr><td>Gara ' . $row['idGara'] . '</td><td>' . str_replace('-','/', $row["dataGara"])  . '</td><td><a href="inserisciRisultatiNoJs.php?value=' . $row['idGara'] . '">Inserisci risultati</a></td></tr>';
    }
    $gare .= '</tbody></table>';
    mysqli_free_result($result);
} else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();


if(isset($_SESSION["risultatoInserimento"]))
{
    $risultatoInserimento = "<br>".$_SESSION["risultatoInserimento"]."</br>";
    unset($_SESSION["risultatoInserimento"]);
}



$pagina = file_get_contents('../../html/admin/inserisciRisultatiNoJs.html');
$pagina = str_replace(
    array("<lista-gare />", "<inserimento-gara-selezionata />", "<risultato-inserimento />", "<torna-indietro />"),
    array($gare, $selezione, $risultatoInserimento, ""),
    $pagina
);
$pagina = areaAutenticazione($pagina);
echo $pagina;
?>
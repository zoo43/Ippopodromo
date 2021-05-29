<?php
require_once('../database.php');
require_once('../auth.php');


if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$gare = '<table><caption>Gare ancora aperte</caption><thead><tr><th>ID gara</th><th>Data</th><th>Opzioni</th></tr></thead><tfoot></tfoot><tbody>';
$selezione = '';
$risultato = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if ($conn) {
    $result = $dbAccess->getGare("0");
    $dbAccess->closeDBConnection();
    while ($row = mysqli_fetch_array($result)) {
        $gare .= '<tr><td>Gara ' . $row['idGara'] . '</td><td>' . $row['dataGara'] . '</td><td><a href="inserisciRisultati.php?value=' . $row['idGara'] . '">Inserisci risultati</a></td></tr>';
    }
    $gare .= '</tbody></table>';
    mysqli_free_result($result);
} else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}

if(isset($_POST['register']))
{
    $conn = $dbAccess->openDBConnection();
    if($conn)
    {
        $dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);
        unset($_SESSION["cavalli"]);
        unset($_SESSION['idGara']);
        unset($_POST['register']);
        $dbAccess->closeDBConnection();
        $risultato = "<p class='inserimentoRiuscito'>Risultato inserito con successo</p>";
        header("Refresh:0");
    }
    else
    {
        echo "problema connessione al DB";
    }
}
$pagina = file_get_contents('../../html/admin/inserisciRisultati.html');
$pagina = str_replace(
    array("<lista-gare />", "<inserimento-gara-selezionata />", "<risultato-inserimento />"),
    array($gare, $selezione, $risultato),
    $pagina
);
$pagina = areaAutenticazione($pagina);
echo $pagina;
?>
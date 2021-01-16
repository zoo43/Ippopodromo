<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
$dbAccess = new DBAccess();

$nome = "";
$immagine = '<img src="../../images/';
$descrizione = "";
$descrizione = "";
$fiducia = "";
$velocita = "";
$stanchezza = "";
$gare = '<table class="risultati-gare"><thead><th>Data</th><th>Posizione</th><tfoot></tfoot><tbody>';

$conn = $dbAccess->openDBConnection();
if ($conn) {
    $result = $dbAccess->getInfoCavallo($params['value']);

    $num_riga = 0;
    while ($row = mysqli_fetch_array($result)) {
        $nome = $nome === "" ? $row['nome'] : $nome;
        $immagine = $immagine === '<img src="../../images/' ? $immagine . $row['immagine'] . '" alt="Foto di ' . $nome . '" />' : $immagine;
        $descrizione = $descrizione === "" ? $row['descrizione'] : $descrizione;
        $fiducia = $fiducia === "" ? $row['fiducia'] : $fiducia;
        $velocita = $velocita === "" ? $row['velocita'] : $velocita;
        $stanchezza = $stanchezza === "" ? $row['stanchezza'] : $stanchezza;
        $gare .= '<tr class="row-'. $num_riga % 2 . '"><td>' . $row['dataGara'] .'</td><td>'.$row['posizione'] .'</td></tr>';
        $id++;
    }
} else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$gare .= "</tbody></table>";
$meta_title = '<meta name="title" content="'.$nome.' - Cavallo - Ippodromo NO₂" />';

$pagina = file_get_contents('../../html/cavalli/cavalloSelezionato.html');
$pagina = str_replace(
    array("<nome-cavallo />", "<meta-title-cavallo />", "<descrizione />", "<fiducia />", "<velocita />", "<stanchezza />", "<risultati-gare />", "<img-cavallo />"),
    array($nome, $meta_title, $descrizione, $fiducia, $velocita, $stanchezza, $gare, $immagine),
    $pagina
);

echo $pagina;

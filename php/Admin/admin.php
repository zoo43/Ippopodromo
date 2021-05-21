<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
// TODO sistemare numeri
if($conn) {
    $result_c = $dbAccess->getCavalli(true);
    $numCavalli = isset($result_c) ? mysqli_num_rows($result_c) : 0;
    $result_r = $dbAccess->getGare('0', true);
    $numGareNonSvolte = isset($result_r) ? mysqli_num_rows($result_r) : 0;
    $result_g = $dbAccess->getGare('0', false);
    $numGareAttesaRisultato = (isset($result_g) ? mysqli_num_rows($result_g) : 0) + $numGareNonSvolte;
    $result_g_conc = $dbAccess->getGare('2');
    $numGare = (isset($result_g_conc) ? mysqli_num_rows($result_g_conc) : 0) + $numGareAttesaRisultato;
}
else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$numCavalli = "$numCavalli cavalli inseriti.";
$numGare = "$numGare gare totali inserite.";
$numGareNonSvolte = "$numGareNonSvolte gare di cui puoi inserire i risultati.";
$pagina = areaAutenticazione(file_get_contents('../../html/admin/admin.html'));

$pagina = str_replace(
    array("<num-cavalli />", "<num-gare />", "<num-risultati />"),
    array($numCavalli, $numGare, $numGareNonSvolte),
    $pagina
);

echo $pagina;

<?php
require_once('../database.php');

$lista_cavalli = '<div id="lista-cavalli">';


$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if ($conn) {
    $result = $dbAccess->getCavalli();
    while ($row = mysqli_fetch_array($result)) {
        $cavallo = '<div class="card-cavallo">
          <h2><nome-cavallo /></h2>
          <img src="../../'.$row['immagine'].'" alt="" class="foto-cavallo" />
          <h3>Fiducia</h3>
          <p><fiducia-cavallo /></p>
          <h3>Velocità</h3>
          <p><velocita-cavallo /></p>
          <p><a href="cavalloSelezionato.php?value='.$row['idCavallo'].'">Informazioni</a></p>
        </div>';
        $cavallo = str_replace(
            array("<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />"),
            array(
                $row['nome'], $row['fiducia'], $row['velocita']
            ),
            $cavallo
        );
        $lista_cavalli .= $cavallo;
    }
} else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
$lista_cavalli .= '</div>';

$pagina = file_get_contents('../../html/cavalli/cavalli.html');
$pagina = str_replace("<lista-cavalli />", $lista_cavalli, $pagina);

echo $pagina;
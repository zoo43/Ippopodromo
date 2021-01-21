<?php
require_once('../database.php');
require_once('../auth.php');

$lista_cavalli = '<div id="lista-cavalli" class="cards">';


$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if ($conn) {
	$result = $dbAccess->getCavalli();
	while ($row = mysqli_fetch_array($result)) {
		$cavallo = '<div class="card">
          <img src="../../images/<foto-cavallo />" alt="<descrizione-cavallo />"/>
          <div class="content">
            <div class="headline"> <h2><nome-cavallo /></h2> </div>
            <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
            <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
            <div class="button"> <h4><a href="cavalloSelezionato.php?value=<id-cavallo />">Informazioni</a></h4> </div>
          </div>
        </div>';
		$cavallo = str_replace(
			array("<foto-cavallo />", "<descrizione-cavallo />", "<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />", "<id-cavallo />"),
			array(
				$row['immagine'], $row['descrizione'], $row['nome'], $row['fiducia'], $row['velocita'], $row['idCavallo']
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
$pagina = areaAutenticazione($pagina);
$pagina = str_replace("<lista-cavalli />", $lista_cavalli, $pagina);


echo $pagina;
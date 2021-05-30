<?php
	require_once('../database.php');
	require_once('../auth.php');
	
	$scommesse = '<div id="scommesse-utente" class="cards">';
	$dbAccess = new DBAccess();
	$conn = $dbAccess->openDBConnection();
	
	if ($conn) {
		if (isset($_SESSION['username'])) {
			
			$query = $dbAccess->getCreditoUtente($_SESSION['username']);
			$_SESSION["credito"] = mysqli_fetch_array($query)['credito'];
			$credito = '<h1 id="h1Bitsquit">Il tuo credito &eacute;: <span>'. $_SESSION['credito'] .'</span></h1>';
			$userResult = $dbAccess->getScommesseUtente($_SESSION['username']);
			
			if ($userResult && mysqli_num_rows($userResult) > 0) {
				if (mysqli_num_rows($userResult) > 0) {
					while ($row = mysqli_fetch_array($userResult)) {
						$scommesse .= '<div class="card"><div class="content">';
						$scommesse .= "<div class='headline'>Numero gara: " . $row['idGara'] . "</div>";
						$scommesse .= "<div class='text'>Data gara: " . $row['dataGara'] . "</div>";
						
						if($row['statoGara'] == '0'){
							$scommesse .= "<div class='text'>Stato gara: programmata</div>";
						}
						else if($row['statoGara'] == '1'){
							$scommesse .= "<div class='text'>Stato gara: in corso</div>";
						}
						else {
							$scommesse .= "<div class='text'>Stato gara: conclusa</div>";
						}
						$scommesse .= "<div class='text'>Cavallo puntato: <a href='../cavalli/cavalloSelezionato.php?value=" . $row['idCavallo'] . "'>" . $row['nome'] . "</a> </div>";
						$scommesse .= "<div class='text'>Valore puntata: " . $row['puntata'] . "</div>";
						if ($row['statoGara'] == '2') {
							$result = $dbAccess->getPosizioneCavalloScommessa($row['idGara'], $row['idCavallo']);
							if ($result && mysqli_num_rows($result) > 0) {
								$posizione = mysqli_fetch_array($result);
								if ($posizione['posizione'] == '1') {
									$scommesse .= "<div class='text' class='win'>Risultati gara: hai vinto </div>";
									} else {
									$scommesse .= "<div class='text' class='lose'>Risultati gara: hai perso </div>";
								}
								mysqli_free_result($result);
							}
							} else {
							$scommesse .= "<div class='text'>Risultati gara: non ancora pubblicati </div>";
						}
						$scommesse .= "</div></div>";
					}
					$scommesse .= "</div>";
				}
				mysqli_free_result($userResult);
			}
		}
		$dbAccess->closeDBConnection();
	}
	
	$pagina = areaAutenticazione(file_get_contents('../../html/scommesse/scommesseUtente.html'));
	$pagina = str_replace(
	array("<lista-scommesse-utente />", "<credito />"),
	array($scommesse, $credito),
	$pagina);
	echo $pagina;
?>

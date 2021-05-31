<?php
require_once('../database.php');
require_once('../auth.php');

if (isset($_SESSION["username"])) {
	$numGara = $_POST['idGara'];
	$dataGara = explode(" ", $_POST['dataGara'])[0];
	$oraGara = explode(" ", $_POST['dataGara'])[1];
	$puntata = $_POST['scommessa'];
	if (isset($_POST["cavallo"])) {
		$idCavallo = $_POST['cavallo'];
		$cavallo = $_POST['nome-cavallo-' . $idCavallo]; // prende il nome del cavallo corrispondente all'id salvato nel post tramite esso

		$input = '<input type="hidden" name="numeroGara" value="' . $_POST['idGara'] . '" />';
		$input .= '<input type="hidden" name="numeroCavallo" value="' . $_POST['cavallo'] . '" />';
		$input .= '<input type="hidden" name="valorePuntata" value="' . $_POST['scommessa'] . '" />';
		$confirm = '<input type="submit" class="button" value="Conferma" />';
	} else {
		$cavallo = "Nessun cavallo selezionato.";
		$input = "";
		$confirm = '<input type="submit" class="button" value="Conferma" disabled="disabled" />';
	}
} else {
	header('Location: scommetti.php');
}

$pagina = areaAutenticazione(file_get_contents('../../html/scommesse/confirmScommessa.html'));
$pagina = str_replace(
	array("<num-gara />", "<data-gara />", "<ora-gara />", "<cavallo />", "<valore-puntata />", "<form-inputs />", "<confirm-input />"),
	array($numGara, $dataGara, $oraGara, $cavallo, $puntata, $input, $confirm),
	$pagina);

echo $pagina;

?>
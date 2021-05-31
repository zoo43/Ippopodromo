<?php
require_once('../database.php');
require_once('../auth.php');


$url = $_SERVER['REQUEST_URI'];
$url_components = parse_url($url);
@parse_str($url_components['query'], $params);
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if ($conn) {
	if (isset($params["value"])) {
		$idgara = $params['value'];
		$result = @$dbAccess->getInfoGara($idgara);
		if (mysqli_num_rows($result) > 0)
		$data =str_replace('-','/', mysqli_fetch_array($result)["dataGara"]);
		if (isset($data)) {
			if (isset($_SESSION["username"])) {
				$creditoUtente = $_SESSION["credito"];
				$credito = '<h1 id="h1Bitsquit">Il tuo credito &eacute;: <span id="creditoUtente">' . $creditoUtente . '</span></h1>';

				$form = '<form method="post" onsubmit="return checkDoc()" action="confirmScommessaGara.php" id="formScommessa" aria-labelledby="form-header"><h2 id="form-header">Fai la tua scommessa</h2>';
				mysqli_free_result($result);
				$form .= '<div>Numero gara: ' . $params["value"] . '</div>';
				$form .= '<div>Data gara: ' . $data . '</div>';
				$form .= '<label for="val-scommessa"><span>Valore scommessa (almeno 1)</span></label><input type="number" name="scommessa" id="val-scommessa" value="1" min="1" max=' . $creditoUtente . ' aria-label="Valore scommessa (almeno 1)" />';
				$cavGara = $dbAccess->getCavalliGara($params['value']);

				$form .= '<fieldset id="horses"><legend>Cavallo</legend><h3>Scegli il cavallo su cui puntare</h3>';
				while ($row = mysqli_fetch_array($cavGara)) {
					$form .= '<div class="flex-div"><input type="radio" name="cavallo" id="horse-' . $row["idCavallo"] . '" value="' . $row["idCavallo"] . '" aria-label="' . $row["nome"] . '" /><label for="horse-' . $row["idCavallo"] . '">' . $row["nome"] . '</label></div>';
					$form .= '<input type="hidden" name="nome-cavallo-' . $row["idCavallo"] . '" value="' . $row["nome"] . '"/>';
				}
				$form .= '</fieldset>';
				mysqli_free_result($cavGara);
				$form .= '<input type="hidden" name="idGara" value="' . $params["value"] . '"/>';
				$form .= '<input type="hidden" name="dataGara" value="' . $data . '"/>';
				$form .= '<input type="submit" name="scommetti" value="Scommetti"/>';
				$dbAccess->closeDBConnection();
				$form .= '</form>';
			} else {
				$form = "<p>Per scommettere devi avere effettuato il login</p>";
				$credito = "Non disponibile";
			}
		} else {
			$idgara = "Non disponibile";
			$form = "<p>Gara non trovata</p>";
			$credito = "Non disponibile";
			$data = "Non disponibile";
		}
	} else {
		$idgara = "Non disponibile";
		$form = "<p>Gara non trovata</p>";
		$credito = "Non disponibile";
		$data = "Non disponibile";
	}
}

$pagina = areaAutenticazione(file_get_contents('../../html/scommesse/garaScommessa.html'));
$pagina = str_replace(
	array("<id-gara />", "<credito />", "<data />", "<form />"),
	array($idgara, $credito, $data, $form),
	$pagina);
echo $pagina;

?>
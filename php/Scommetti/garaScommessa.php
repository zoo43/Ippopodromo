<?php
require_once('../database.php');
require_once('../auth.php');


$url = $_SERVER['REQUEST_URI'];
$url_components = parse_url($url);
@parse_str($url_components['query'], $params);
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
	$idgara = $params['value'];
	$result=@$dbAccess->getInfoGara($idgara);
	if(mysqli_num_rows($result)>0)
	$data = mysqli_fetch_array($result)["dataGara"];
	if(isset($data))
	{
		if(isset($_SESSION["username"]))
		{
		$creditoUtente = $_SESSION["credito"];
		$credito = '<h1 id="h1Bitsquit">Il tuo credito &eacute;: <span>'. $creditoUtente .'</span></h1>';
		
		$form = '<form method="post" onsubmit="return checkDoc()" action="confirmScommessaGara.php" id="formScommessa">';
		mysqli_free_result($result);
		$form .= 'Numero Gara: <label form="formScommessa">'.$params["value"].'</label><br />';
		$form .= 'Data Gara: <label form="formScommessa">'.$data.'</label><br />';
		$form .= '<input type="number" name="scommessa" value="1" min="1" max='.$creditoUtente.'><br />';
		$cavGara = $dbAccess->getCavalliGara($params['value']);

		while($row = mysqli_fetch_array($cavGara))
		{
			$form .= '<input type="radio" name="cavallo" value="'.$row["idCavallo"].'">'.$row["nome"].'<br />';
		}
		mysqli_free_result($cavGara);
		$form .= '<input type="hidden" name="idGara" value="'.$params["value"].'"/>';
		$form .= '<input type="hidden" name="dataGara" value="'.$data.'"/>';
		$form .= '<input type="submit" name="scommetti" value="Scommetti"/>';
		$dbAccess->closeDBConnection();
		$form .= '</form>';
		} else
		{
			$form = "<p>Per scommettere devi avere effettuato il login</p>";
			$credito = "Non disponibile";
		}
	} else
	{
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

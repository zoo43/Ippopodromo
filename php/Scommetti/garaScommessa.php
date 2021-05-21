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
	if(isset($_SESSION["username"]))
	{
	$creditoUtente = $_SESSION["credito"];
	echo '<form method="post" onsubmit="return checkDoc($creditoUtente);" action="confirmScommessaGara.php" id="formScommessa">';
	$idgara = $params['value'];
	$result=@$dbAccess->getInfoGara($idgara);
	$data = mysqli_fetch_array($result)["dataGara"];
	mysqli_free_result($result);
	echo 'Numero Gara: <label form="formScommessa">'.$params["value"].'</label><br />';
	echo 'Data Gara: <label form="formScommessa">'.$data.'</label><br />';
	echo '<input type="number" name="scommessa" value="1" min="1" max='.$creditoUtente.'>'; 
	print("<br />");
	$cavGara = $dbAccess->getCavalliGara($params['value']);
	
	while($row = mysqli_fetch_array($cavGara))
	{
		print('<input type="radio" name="cavallo" value="'.$row["idCavallo"].'">'.$row["nome"]);
		print("<br />");
	}
	mysqli_free_result($cavGara);
	echo '<input type="hidden" name="idGara" value="'.$params["value"].'"/>';
	echo '<input type="hidden" name="dataGara" value="'.$data.'"/>';
	echo '<button type="submit" name="scommetti">Scommetti</button>';
	$dbAccess->closeDBConnection();
	echo '</form>';
	}
}
echo "<p><a href='scommetti.php'> Torna indietro </a></p>";

$pagina = areaAutenticazione(file_get_contents('../../html/scommesse/garaScommessa.html'));
$pagina = str_replace(
	array("<id-gara />", "<credito />", "<data />"),
	array($idgara, $creditoUtente, $data),
	$pagina);
echo $pagina;

?>
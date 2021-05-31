<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn)
{
	if(isset($_SESSION['username']))
	{
		if($dbAccess->aggiuntaScommessa($_SESSION['username'],$_POST['numeroGara'],$_POST['numeroCavallo'],$_POST['valorePuntata']))
		{
			$row = $dbAccess->getCreditoUtente($_SESSION['username']);
			$_SESSION['credito'] = mysqli_fetch_array($row)['credito'];
			$risultato = '<p class="inserimentoRiuscito">Il pagamento è avvenuto con successo. </p>';
			$titolo = 'Scommessa confermata';
			$meta_title = '<meta name="title" content="Scommessa confermata - Ippodromo NO₂¯" />';
		}else
		{
			$risultato = '<p class="inserimentoFallito" Si è verificato un errore imprevisto. Si prega di attendere prima di riprovare.';
			$titolo = 'Scommessa non riuscita';
			$meta_title = '<meta name="title" content="Scommessa non riuscita - Ippodromo NO₂¯" />';
		}
	}
	$dbAccess->closeDBConnection();
}
$risultato .= "<p><a href='scommesse.php'> Torna alle scommesse </a></p>";
$pagina = areaAutenticazione(file_get_contents('../../html/scommesse/risultatoScommessa.html'));
$pagina = str_replace(
	array("<risultato />", "<titolo-risultato />", "<meta-title-risultato />"),
	array($risultato, $titolo, $meta_title),
	$pagina);

echo $pagina;

?>

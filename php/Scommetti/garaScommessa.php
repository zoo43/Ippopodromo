<?php
require_once('../database.php');
session_Start();

$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
@parse_str($url_components['query'], $params); 
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
	if(isset($_SESSION["username"]))
	{
	echo '<form method="post" onsubmit="return validazioneInput()" action="checkScommessaGara.php">';
	$result=@$dbAccess->getInfoGara($params['value']);
	echo '<input type="number" name="scommessa" value="1" min="1" max='.$credito = $_SESSION["credito"].'>'; 
	print("<br />");
	$cavGara = $dbAccess->getCavalliGara($params['value']);
	while($row = mysqli_fetch_array($cavGara))
	{
		print('<input type="radio" name="'.$row["nome"].'">'.$row["nome"]);
		print("<br />");
	}
	echo '<button type="submit" name="scommetti">Scommetti</button>';
	$dbAccess->closeDBConnection();
	echo '</form>';
	}
}
echo "<p><a href='scommetti.php'> Torna indietro </a></p>";
?>
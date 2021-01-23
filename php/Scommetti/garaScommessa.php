<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
			function checkDoc(var userBitSquits)
			{
				if(checkBitSquits(userBitSquits) && checkRadio())
				{
					return true;
				}
				else {
					return false;
				}
			}
			
			function checkBitSquits(var userBitSquits)
			{
				var n = document.getElementsByTagName('input');
				var value;
				for (var i = 0; i < n.length; i++) {
					if (n[i].type === 'number')
					{
						if(n[i].value <= userBitSquits)
						return true;
						else
						{
							alert('Non hai abbastanza bitSquits :(. Si prega di inserire un importo valido');
							return false;
						}
					}
				}
				alert('Qualcosa è andato storto :(');
				return false;
			}
			
            function checkRadio()
            {
				var radios = document.getElementsByTagName('input');
				var value;
				for (var i = 0; i < radios.length; i++) {
					if (radios[i].type === 'radio' && radios[i].checked)
					{
						return true;
					}
				}
				alert('Non è stato selezionato nessun cavallo su cui scommettere');
				return false;
            }
        </script>
</head>

<body>
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
	$result=@$dbAccess->getInfoGara($params['value']);
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
?>
</body>
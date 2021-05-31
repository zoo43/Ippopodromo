<?php
	require_once('../database.php');
	require_once('../auth.php');
	
	$dbAccess = new DBAccess();
	$conn = $dbAccess->openDBConnection();
	
	$scommesse='<div id="lista-scommesse" class="cards">';
	$credito='<h1 id="h1data">registrati per avere il tuo credito</h1>';
	$storico='';
	
	if($conn)
	{
		if(isset($_SESSION["username"]))
		{
			$username = $_SESSION["username"];
			$query = $dbAccess->getCreditoUtente($username);
			$_SESSION["credito"] = mysqli_fetch_array($query)["credito"];
			$credito = '<h1 id="h1Bitsquit">Il tuo credito &eacute;: <span>'. $_SESSION["credito"] .'</span></h1>';
			
			$result = $dbAccess->getGare("0");
			
			while($row = mysqli_fetch_array($result))
			{          
				$id=$row['idGara'];
				$arr=explode(" ",str_replace('-','/',$row['dataGara']));
				$giorno = $arr[0];
				$ora=$arr[1];
				$contains = false;
				$resultGareUtente = $dbAccess->getScommesseUtente($username);
				while($rowGareUtente = mysqli_fetch_array($resultGareUtente))
				{
					if($rowGareUtente["idGara"] == $id)
					{
						$contains = true;
					}
				}
				if($contains == false)
				{
					$scommessa = '<div class="card">
					<div class="content">
					<div class="headline"> <h2>Gara <id-scommessa /></h2> </div>
					<div class="text"> <h3>Data: <data /></h3> </div>
					<div class="text"> <h3>Ora: <ora /></h3>  </div>
					<a href="garaScommessa.php?value=<id-scommessa />"> <div class="button"> <h4>Punta</h4> </div></a>
					</div>
					</div>';
					$scommessa = str_replace(
					array("<id-scommessa />", "<data />", "<ora />"),
					array(
					$id, $giorno, $ora),
					$scommessa
					);
					$scommesse .= $scommessa;
				}
			}
			$storico = '<div class="centerLink"><a href="scommesseUtente.php">Visualizza le tue scommesse</a></div>';
			mysqli_free_result($result);
		}
		else
		{
			$scommesse .= '<h2>Registrati per visualizzare le gare</h2>';
			
		}
	}
	else
	{
		$scommesse .= '<h2>Errore di connessione</h2>';
	}
	
	$scommesse .= '</div>';
	
	$dbAccess->closeDBConnection();
	
	$pagina = file_get_contents('../../html/scommesse/scommesse.html');
	$pagina = areaAutenticazione($pagina);
	$pagina = str_replace(
    array("<lista-scommesse />", "<credito />", "<storico />"),
    array($scommesse, $credito, $storico),
    $pagina
	);
	
	
	echo $pagina;
?>
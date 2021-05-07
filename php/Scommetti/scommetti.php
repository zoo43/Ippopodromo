<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$scommesse='<div id="lista-scommesse" class="cards">';
$credito='registrati per avere il tuo credito';
$storico='';

if($conn)
{
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    
    $result = $dbAccess->getGare("0");
	$noAdd = $dbAccess->getScommesseUtente($username);
    while($row = mysqli_fetch_array($result))
    {         
		$toAdd = true;
        $id=$row['idGara'];
		while($rowNoAdd = mysqli_fetch_array($noAdd))
		{
			if($id==$rowNoAdd['idGara'])
			$toAdd = false;
		}
		if($toAdd)
		{
			$arr=explode(" ",$row['dataGara']);
			$giorno = $arr[0];
            $ora=$arr[1];
		
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

    $storico = '<tr>
              <td><a href="scommesseUtente.php">Visualizza le tue scommesse</a></td>
            </tr>';
    mysqli_free_result($result);
}
else
{
    $scommesse .= '<div class="card">
          <div class="content">
            <div class="headline"> <p>Registrati per visualizzare le gare</p> </div></div>';

}
}
else
{
	$scommesse .= '<div class="card">
          <div class="content">
            <div class="headline"> <h2>Errore di connessione</h2> </div></div>';
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
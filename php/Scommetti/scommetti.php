<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$scommesse='';


if($conn)
{
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    echo $username . " Credito:" . $credito;
    $result = $dbAccess->getGare("0");
    while($row = mysqli_fetch_array($result))
    {          
        echo "<p>" . "Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</p>";  
		echo "<p><a href='garaScommessa.php?value=".$row['idGara']."'>Scommetti sulla gara</p></a>";
    }
	
	echo "<a href='scommesseUtente.php'>Visualizza le tue scommesse</a>";



    $cavallo = '<div class="card">
          <div class="content">
            <div class="headline"> <h2>Gara <numero-gara /></h2> </div>
            <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
            <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
            <div class="button"> <h4><a href="cavalloSelezionato.php?value=<id-cavallo />">Informazioni</a></h4> </div>
          </div>
        </div>';
        $cavallo = str_replace(
            array("<foto-cavallo />", "<descrizione-cavallo />", "<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />", "<id-cavallo />"),
            array(
                $row['immagine'], $row['descrizione'], $row['nome'], $row['fiducia'], $row['velocita'], $row['idCavallo']
            ),
            $cavallo
        );
        $lista_cavalli .= $cavallo;


    mysqli_free_result($result);
}
else
{
    echo "Accedi per poter scommettere";
}
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";

$pagina = file_get_contents('../../html/cavalli/cavalli.html');
$pagina = areaAutenticazione($pagina);
$pagina = str_replace("<lista-cavalli />", $lista_cavalli, $pagina);


echo $pagina;
?>
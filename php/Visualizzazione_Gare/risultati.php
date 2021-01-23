<?php
require_once('../database.php');
require_once('../auth.php');


$lista_gare = "";

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
    $result = $dbAccess->getGare("2");
    if(isset($result))
    {
        while($row = mysqli_fetch_array($result))
        {          
            $arr=explode(" ",$row['dataGara']);
            $giorno = $arr[0];
            $ora=$arr[1];
            
            $lista_gare .= "<li><a href='garaSelezionata.php?value=". $row['idGara'] ."'>Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</a></li>";
        }
    }
    else {
        $lista_gare = "<li>Ancora nessuna gara si é conclusa</li>";
    }
    mysqli_free_result($result);
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$pagina = file_get_contents('../../html/gare/risultati.html');
$pagina = str_replace(
    array("<lista-gare />", "<cambio-pagina />"),
    array($lista_gare, ""),
    $pagina
);
$pagina = areaAutenticazione($pagina);

echo $pagina;
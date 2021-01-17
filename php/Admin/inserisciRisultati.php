<?php
require_once('../../php/database.php');
session_Start();
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params);

     

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
    $result = $dbAccess->getCavalliGara($params['value']);
    $_SESSION['idGara'] = $params['value'];
    $i=0;
    $cavalli;
    while($row = mysqli_fetch_array($result))
    {   
        $array['id'] = $row['idCavallo'];
        $array['name'] = $row['nome'];
        $cavalli[$i] = $array;
        $i++;
    }
    mysqli_free_result($result);
    $i=0;
    $risultati="";
    $_SESSION["cavalli"] = $cavalli;
    for($i=0; $i<count($cavalli);$i++)
    {
        $risultati = $risultati. $cavalli[$i]['name'];
        $risultati = $risultati. "<input type='number' id=' ".$cavalli[$i]['id']."' placeholder='Pos' name='cavalli[]' min='1' max='".count($cavalli)."' required><br/>";
    }

    $pagina = file_get_contents("../../html/admin/inserisciRisultati.html");
    echo str_replace(
        array("<risultati />"),
        array($risultati), 
        $pagina
    );


}
$dbAccess ->closeDBConnection();
?>
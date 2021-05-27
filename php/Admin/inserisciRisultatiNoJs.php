<?php
require_once('../../php/database.php');
session_Start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params);

$gare = '';
$selezione = '<form method="post" action="aggiungiRisultatiNoJs.php" id="inserimentoCavallo" enctype="multipart/form-data"><h1>Inserisci i risultati della gara:</h1>';
$risultato = '';
$dbAccess = new DBAccess();

if(isset($params['value'])) {
$conn = $dbAccess->openDBConnection();
if($conn) {
    $_SESSION['idGara'] = $params['value'];
    $i=0;
    $cavalli;
    $result = $dbAccess->getCavalliGara($params['value']);
    while($row = mysqli_fetch_array($result))
    {   
        $array['id'] = $row['idCavallo'];
        $array['name'] = $row['nome'];
        $cavalli[$i] = $array;
        $i++;
    }
    mysqli_free_result($result);
    $i=0;
    $_SESSION["cavalli"] = $cavalli;
    for($i=0; $i<count($cavalli);$i++)
    {
        $selezione .= '<label for="cav'. $cavalli[$i]['id'] .'">' . $cavalli[$i]['name'] . '</label>';
        $selezione .= "<input type='number' id='cav".$cavalli[$i]['id']."' placeholder='Pos' name='cavalli[]' value='1' min='1' max='".count($cavalli)."' required><br/>";
    }
    $selezione .= '<button id="btn" type="submit" name="register">Inserisci</button></form>';
    $dbAccess->closeDBConnection();
}
else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
}
else {
    $risultato = "<p class='inserimentoFallito'>C'é stato un errore con l'id della gara passato</p>";
}

$pagina = file_get_contents('../../html/admin/inserisciRisultatiNoJs.html');
$pagina = str_replace(
    array("<lista-gare />", "<inserimento-gara-selezionata />", "<risultato-inserimento />"),
    array($gare, $selezione, $risultato),
    $pagina);
echo $pagina;
?>
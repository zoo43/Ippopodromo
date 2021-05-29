<?php
require_once('../database.php');
require_once('../auth.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params);

$gare = '';
$selezione = '<form method="post" action="aggiungiRisultatiNoJs.php" id="inserimentoCavallo" enctype="multipart/form-data"><h2 id="form-header">Inserisci i risultati della gara</h2>';
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
            $selezione .= '<label for="cav' . $cavalli[$i]['id'] . '"><span>' . $cavalli[$i]['name'] . '</span></label>';
            $selezione .= "<input type='number' onchange='controllaPosizioni()' id='cav" . $cavalli[$i]['id'] . "' name='cavalli[]' value='1' min='1' max='" . count($cavalli) . "' aria-label=" . $cavalli[$i]['name'] . "required='required' />";
        }
        $selezione .= '<input id="btn" type="submit" name="register" disabled="disabled" value="Aggiorna risultati" /></form>';
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
$pagina = areaAutenticazione($pagina);
echo $pagina;
?>
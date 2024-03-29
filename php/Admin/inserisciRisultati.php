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
$selezione = '<form method="post" action="verificaInserimento.php" id="inserimentoRisultato"><h2 id="form-header">Inserisci i risultati della gara</h2><p>Non ci possono essere cavalli nella stessa posizione (nessun parimerito)</p>';
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
            $selezione .= '<label for="cav' . $cavalli[$i]['id'] . '"><span>' . $cavalli[$i]['name'] . '</span><span class="visually-hidden">(Richiesto)</span></label>';
            $selezione .= "<input type='number' id='cav" . $cavalli[$i]['id'] . "' name='cavalli[]' value='1' min='1' max='" . count($cavalli) . "' aria-label='" . $cavalli[$i]['name'] . "' required='required' />";
    }
    $selezione .= '<input id="btn" type="submit" onclick="controllaPosizioni()" name="register" value="Aggiorna risultati" /></form>';
    $dbAccess->closeDBConnection();
}
else {
        $risultato = "<p class='inserimentoFallito'>C'é stato un errore con l'id della gara passato</p>";
}
}
else {
    $risultato = "<p class='inserimentoFallito'>C'é stato un errore con l'id della gara passato</p>";
}

$torna_indietro = '<a href="./aggiungiRisultati.php" class="centerLink">Torna indietro</a>';

$pagina = file_get_contents('../../html/admin/inserisciRisultati.html');
$pagina = str_replace(
    array("<lista-gare />", "<inserimento-gara-selezionata />", "<risultato-inserimento />", "<torna-indietro />"),
    array($gare, $selezione, $risultato, $torna_indietro),
    $pagina);
$pagina = areaAutenticazione($pagina);
echo $pagina;
?>
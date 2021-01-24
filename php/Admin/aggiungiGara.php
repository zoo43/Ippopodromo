<?php 
require_once('../database.php');

function listaCavalliToString($dbAccess, $cavalli)
{
    $result = $dbAccess->getCavalli(true);
    while($row = mysqli_fetch_array($result))
    {                                                                       
        $id = $row['idCavallo'];
        $name = $row['nome'];
        $cavalli = $cavalli . "<input type='checkbox' onchange='controllaNumeroCavalli()' id='$id' name='cavalli[]' value='$id'><label for='$id'>$name</label>";
    }
    mysqli_free_result($result);
    return $cavalli;
}

$cavalli = '';
$risultatoAggiunta = '';
$gare = '';
$pagina = file_get_contents('../../html/admin/aggiungiGara.html');
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
    $result = $dbAccess->getGare("0");
    while($row = mysqli_fetch_array($result)) {
        $gare .= '<tr><td>Gara' . $row['idGara'] . '</td><td>' . $row['dataGara'] . '</td><td><a href=inserisciRisultati?value="' . $row['idGara'] . '">Inserisci risultati</td></tr>';
    }
    $dbAccess->closeDBConnection();
    mysqli_free_result($result);
    
    $pagina = str_replace("<lista-gare />", $gare, $pagina);
} else {
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}

if(isset($_POST['register']))
{
    $conn = $dbAccess->openDBConnection();
    if($conn) {
        if($dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']))
        {
            $risultatoAggiunta = "<p class='inserimentoRiuscito'>Gara inserita con successo</p>";
        }
        else
        {
            $risultatoAggiunta = "<p class='inserimentoFallito'>C'è stato un problema con la creazione della gara</p>";
        }
        $dbAccess->closeDBConnection();
    }
    else {
        $risultatoAggiunta = "<p class='inserimentoFallito>Problema durante la connessione al database.";
    }
    
    $pagina = str_replace("<risultati-inserimento />", $risultatoAggiunta, $pagina);
    unset($_POST['register']);
}

echo $pagina;
?>
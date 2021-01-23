<?php 
require_once('../database.php');

$risultatiAggiunta = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if(isset($_POST['register']))
{
if($conn)
{
    if($dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']))
    {
        $risultatiAggiunta = "<p class='inserimentoRiuscito>Gara inserita con successo</p>";
    }
    else
    {
        $risultatoAggiunta .= "<p class='inserimentoFallito'>C'è stato un problema</p>";
    }
    $dbAccess->closeDBConnection();
}
else{
    $risultatoAggiunta = "<p class='inserimentoFallito'>Problema di connessione al DB</p>";}
}
else{
$cavalli = "";
if($conn)
{
    $result = $dbAccess->getCavalli();
    while($row = mysqli_fetch_array($result))
    {                                                                       
        $id = $row['idCavallo'];
        $name = $row['nome'];
        $cavalli = $cavalli . "<input type='checkbox' onchange='controllaNumeroCavalli()' id='$id' name='cavalli[]' value='$id'><label for='$id'>$name</label>";
    }
    mysqli_free_result($result);
    $dbAccess->closeDBConnection();
}
else
{
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}


$pagina = file_get_contents("../../html/admin/aggiungiGara.html");
$pagina = str_replace(
    array("<risultati-inserimento />", "<cavalli />"),
    array($risultatiAggiunta, $cavalli), 
    $pagina
);
}

echo $pagina;
?>
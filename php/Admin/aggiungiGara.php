<?php 
require_once('../database.php');
require_once('../auth.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$risultatoAggiunta = '';
$cavalli = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


function stampaListaCavalli($dbAccess,$cavalli)
{
    $result = $dbAccess->getCavalli(true);
    while($row = mysqli_fetch_array($result))
    {                                                                       
        $id = $row['idCavallo'];
        $name = $row['nome'];
        $cavalli = $cavalli . "<div class='flex-div'><input type='checkbox' id='$id' name='cavalli[]' value='$id' aria-label='$name'> <label for='$id'><span>$name</span></label></div>";
    }
    mysqli_free_result($result);
    return $cavalli;
}


if($conn)
{
    $cavalli=stampaListaCavalli($dbAccess, $cavalli);
    $dbAccess->closeDBConnection();
}
else
{
    $risultatoAggiunta = "Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.";
}

if(isset($_SESSION["risultatoInserimento"]))
{
    $risultatoAggiunta = $_SESSION["risultatoInserimento"];
    unset($_SESSION["risultatoInserimento"]);
}

$pagina = file_get_contents("../../html/admin/aggiungiGara.html");
$pagina = str_replace(
    array("<risultati-inserimento />", "<cavalli />"),
    array($risultatoAggiunta, $cavalli), 
    $pagina
);
$pagina = areaAutenticazione($pagina);
echo $pagina;
?>
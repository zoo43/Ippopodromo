<?php 
require_once('../database.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
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
}
else
{
    printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$pagina = file_get_contents("../../html/admin/aggiungiGara.html");


echo str_replace(
    array("<cavalli />"),
    array($cavalli), 
    $pagina
);
?>
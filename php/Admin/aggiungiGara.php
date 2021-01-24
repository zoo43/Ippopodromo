<?php 
require_once('../database.php');



$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if(isset($_POST['register']))
{
if($conn)
{
if($dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']))
{
    echo "Gara inserita con successo";
}
else
{
    echo "C'è stato un problema";
}

echo "//Pulsante per tornare indietro";
$dbAccess->closeDBConnection();
}
else{
echo "Problema di connessione al DB";}
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


echo str_replace(
    array("<cavalli />"),
    array($cavalli), 
    $pagina
);
}


?>
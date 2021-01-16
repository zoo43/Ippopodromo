<?php
require_once('../database.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
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
?>
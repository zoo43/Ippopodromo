<?php
require_once('database.php');


if(isset($_POST['register'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    $dbAccess->inserisciUtente("Luca","Paolo");
    $dbAccess->closeDBConnection();
}
?>
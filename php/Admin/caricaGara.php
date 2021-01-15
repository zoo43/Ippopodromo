<?php
require_once('../database.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
$dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']);
$dbAccess->closeDBConnection();
?>
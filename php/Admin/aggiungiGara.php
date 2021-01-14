<?php

require_once('../database.php');
echo "ciaooo";
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{

}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

?>
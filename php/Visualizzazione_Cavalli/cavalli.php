<!DOCTYPE html>
<html>
<p> Bella Gattina </p>
</html>

<?php
require_once('../database.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn){
$result = $dbAccess->getCavalli();
while($row = mysqli_fetch_array($result))
{                                                                       
    print("<p><a href='cavalloSelezionato.php?value=" . $row['idCavallo'] . "'>".$row['nome'] . "</a></p>");
    print("<br />");
}
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection(); 
echo "<p><a href='../../'>Torna indietro </a></p>"
?>


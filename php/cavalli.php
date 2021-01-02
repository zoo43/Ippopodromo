<!DOCTYPE html>
<html>
<p> Bella Gattina </p>
</html>

<?php
require_once('database.php');
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
$result = $dbAccess->getCavalli();
while($row = mysqli_fetch_array($result))
{                                                                       //Nome Cavallo
    print("<p><a href='cavalloSelezionato.php?value=" . $row['idCavallo'] . "'>".$row['idCavallo'] ." ".  $row['descrizione']."</a></p>");
    print("<br>");
}

$dbAccess->closeDBConnection(); 

echo "<p><a href='../'>Torna indietro </a></p>"
?>

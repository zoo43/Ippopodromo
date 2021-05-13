<?php
require_once('../database.php');
require_once('../auth.php');

$lista = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn) {
    $result = $dbAccess->getCavalli(true);
    while($row = mysqli_fetch_array($result)) {
        $lista .= "<tr><td>" . $row['nome'] . "</td><td><a href='rimuoviCavallo.php?value=" . $row['idCavallo'] . "'>Elimina</td></tr>";
    }
}
else {
    printf('Si é verificato un errore con la connessione al database.');
}

$pagina = areaAutenticazione(file_get_contents('../../html/admin/gestisciCavalli.html'));
$pagina = str_replace("<lista-cavalli />", $lista, $pagina);

echo $pagina;
?>
<?php
require_once('../database.php');
require_once('../auth.php');

if(!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$lista = '';
$risultato = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


if($conn) {
    $result = $dbAccess->getCavalli(true);
    while($row = mysqli_fetch_array($result)) {
        $lista .= "<tr><td>" . $row['nome'] . "</td><td><a href='rimuoviCavallo.php?value=" . $row['idCavallo'] . "'>Elimina</a></td></tr>";
    }
}
else {
    printf('Si é verificato un errore con la connessione al database.');
}

if(isset($_SESSION["risultatoEliminazione"]))
{
    $risultato= "<br>".$_SESSION["risultatoEliminazione"]."</br>";
    unset($_SESSION["risultatoEliminazione"]);
}

$dbAccess->closeDBConnection();
$pagina = areaAutenticazione(file_get_contents('../../html/admin/gestisciCavalli.html'));
$pagina = str_replace(array("<lista-cavalli />","<risultato-eliminazione />"), array($lista, $risultato), $pagina);
$pagina = areaAutenticazione($pagina);

echo $pagina;
?>
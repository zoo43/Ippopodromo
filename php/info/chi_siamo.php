<?php
require_once("../auth.php");

$pagina = file_get_contents("../../html/chi_siamo.html");
$pagina = areaAutenticazione($pagina);

echo $pagina;

?>
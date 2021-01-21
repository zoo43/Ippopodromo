<?php
require_once('php/auth.php');

$pagina = areaAutenticazione(file_get_contents('html/index.html'), true);
echo $pagina;

?>
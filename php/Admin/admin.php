<?php
require_once('../auth.php');

$pagina = areaAutenticazione(file_get_contents('../../html/admin/admin.html'));

echo $pagina;

?>
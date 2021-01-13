<?php
session_Start();
if(isset($_SESSION["username"]))
{
    print($_SESSION["username"]);
    $autenticazione = "<li><a href='php/Autenticazione/logout.php'>Logout</a></li>";
}
else{
    $autenticazione = "<li><a href='php/Autenticazione/register.php'>Registrati</a></li>
    <li><a href='php/Autenticazione/login.php'>Login </a></li>";
}
$pagina = file_get_contents("html/index.html");
echo str_replace("<autenticazione />", $autenticazione, $pagina);
?>
<?php
session_Start();
$admin = "";
if(isset($_SESSION["username"]))
{
    print($_SESSION["username"]);
    if(isset($_SESSION["admin"]))
    {
        $admin = "<li><a href='html/aggiungiGara.html'>Aggiungi gara! (Solo admin)</a></li>";
    }
    $autenticazione = "<li><a href='php/Autenticazione/logout.php'>Logout</a></li>";
}
else{
    $autenticazione = "<li><a href='php/Autenticazione/register.php'>Registrati</a></li>
    <li><a href='php/Autenticazione/login.php'>Login </a></li>";
}
$pagina = file_get_contents("html/index.html");


echo str_replace(
    array("<autenticazione />","<admin />"),
    array($autenticazione, $admin), 
    $pagina
);


?>
<?php
session_Start();
$admin = "";
$scommessa = "";
if(isset($_SESSION["username"]))
{
    if(isset($_SESSION["admin"]))
    {
        header("location:../html/admin/admin.html");
    }
    else
    {
        $autenticazione = "<li><a href='php/Autenticazione/logout.php'>Logout</a></li>";
    }
}
else{
    $autenticazione = "<li><a href='php/Autenticazione/register.php'>Registrati</a></li>
    <li><a href='php/Autenticazione/login.php'>Login </a></li>";
}
$pagina = file_get_contents("html/index.html");


echo str_replace(
    array("<autenticazione />"),
    array($autenticazione), 
    $pagina
);


?>
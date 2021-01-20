<?php
session_Start();

function areaAutenticazione($pagina){
    $admin = "";
    if(isset($_SESSION["username"]))
    {
        print($_SESSION["username"]);
        if(isset($_SESSION["admin"]))
        {
            $admin = "<li><a href='php/Admin/aggiungiGara.php'>Aggiungi gara! (Solo admin)</a></li>";
        }
        $autenticazione = "<li><a href='php/Autenticazione/logout.php'>Logout</a></li>";
    }
    else{
        $autenticazione = "<li><a href='php/Autenticazione/register.php'>Registrati</a></li>
        <li><a href='php/Autenticazione/login.php'>Login </a></li>";
    }


    return str_replace(
        array("<autenticazione />","<admin />"),
        array($autenticazione, $admin), 
        $pagina
    );
}

$pagina = areaAutenticazione(file_get_contents('html/index.html'));
echo $pagina;

?>
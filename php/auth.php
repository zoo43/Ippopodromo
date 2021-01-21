<?php
session_Start();
function areaAutenticazione($pagina){
    $admin = "";
    if(isset($_SESSION["username"]))
    {
        if(isset($_SESSION["admin"]))
        {
            $admin = "<li><a href='../Admin/aggiungiGara.php'>Aggiungi gara!</a></li>";
        }
        $autenticazione = "<li><a href='../Autenticazione/logout.php'>Logout</a></li>";
    }
    else{
        $autenticazione = "<li><a href='../Autenticazione/register.php'>Registrati</a></li>
        <li><a href='../Autenticazione/login.php'>Login </a></li>";
    }


    return str_replace(
        array("<autenticazione />","<admin />"),
        array($autenticazione, $admin), 
        $pagina
    );
}

?>
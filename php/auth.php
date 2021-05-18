<?php
session_start();
function areaAutenticazione($pagina, $index = false){
    $admin = "";
    if(isset($_SESSION["username"]))
    {
        if(isset($_SESSION["admin"]))
        {
            $admin = "<li><a href='../Admin/admin.php'>Pannello amministratore</a></li>";
            if ($index) {
                $admin = "<li><a href='php/Admin/admin.php'>Pannello amministratore</a></li>";
            }
        }
        $autenticazione = "<li><a href='../Autenticazione/logout.php'>Logout</a></li>";
    }
    else{
        $autenticazione = "<li><a href='../Autenticazione/login.php'>Login </a> / <a href='../Autenticazione/register.php'>Registrati</a></li>";
    }

    if($index) {
        [$admin, $autenticazione] = str_replace("..", "php", array($admin, $autenticazione));
    }

    return str_replace(
        array("<autenticazione />","<admin />"),
        array($autenticazione, $admin), 
        $pagina
    );
}

?>
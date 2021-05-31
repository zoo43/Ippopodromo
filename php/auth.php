<?php
session_start();
function areaAutenticazione($pagina, $index = false){
    $admin = "";
    if(isset($_SESSION["username"]))
    {
        if(isset($_SESSION["admin"]))
        {
            $admin = "<li><a href='../admin/admin.php'>Dashboard</a></li>";
            if ($index) {
                $admin = "<li><a href='php/admin/admin.php'>Dashboard</a></li>";
            }
        }
        $autenticazione = "<li><a href='../autenticazione/logout.php'>Logout</a></li>";
    }
    else{
        $autenticazione = "<li><a href='../autenticazione/login.php'>Login</a></li><li><a href='../autenticazione/register.php'>Registrati</a></li>";
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

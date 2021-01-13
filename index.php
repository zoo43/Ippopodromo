<!DOCTYPE html>
<html>
<title> Paolo </title>
<head>
    
</head>
    <body>
        <p><a href="php/Scommetti/scommetti.php">Scommetti Subito!</a></p>
        <p><a href="php/Visualizzazione_Gare/risultati.php">Risultati</a></p>
        <p><a href="php/Visualizzazione_Cavalli/cavalli.php"> Cavalli</a></p>

    </body>

<?php
session_Start();
if(isset($_SESSION["username"]))
{
    print($_SESSION["username"]);
    echo "<p><a href='php/Autenticazione/logout.php'>Logout</a></p>";
}
else{
    echo "<p><a href='php/Autenticazione/register.php'>Registrati Subito! </a></p>
    <p><a href='php/Autenticazione/login.php'>Login </a></p>";
}
?>
</html>
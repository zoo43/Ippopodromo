<?php
require_once('../database.php');
session_Start();

if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    echo $username . " Credito:" . $credito;
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    $result = $dbAccess->getRisultati("0");
    while($row = mysqli_fetch_array($result))
    {          
        echo "<p>" . "Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</p>";                                                       
    }
$dbAccess->closeDBConnection();
}
else
{
    echo "Accedi per poter scommettere";
}

?>
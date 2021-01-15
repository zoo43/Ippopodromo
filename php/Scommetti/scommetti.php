<?php
require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
if($dbAccess->openDBConnection())
{
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    echo $username . " Credito:" . $credito;
    $result = $dbAccess->getRisultati("0");
    while($row = mysqli_fetch_array($result))
    {          
        echo "<p>" . "Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</p>";                                                       
    }
}
else
{
    echo "Accedi per poter scommettere";
}
	$dbAccess->closeDBConnection();
}

echo "<p><a href='../../'> Torna indietro </a></p>";
?>
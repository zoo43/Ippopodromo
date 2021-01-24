<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
if(isset($_SESSION["username"]))
{
    $username = $_SESSION["username"];
    $credito = $_SESSION["credito"];
    echo $username . " Credito:" . $credito;
    $result = $dbAccess->getGare("0");
	if(mysqli_num_rows($result)>0)
	{
    while($row = mysqli_fetch_array($result))
    {
	$insert = true;
	$lsu = $dbAccess->getScommesseUtente($username);
		if(mysqli_num_rows($lsu)>0)
		{
		while($rowlsu = mysqli_fetch_array($lsu)) 
		{
			if($rowlsu['idGara'] == $row['idGara'])
			{
				$insert = false;
			}
		}
		if($insert){
		echo "<p>" . "Numero Gara: ". $row['idGara'] . " Data della Gara:" . $row['dataGara'] ."</p>";  
		echo "<p><a href='garaScommessa.php?value=".$row['idGara']."'>Scommetti sulla gara</p></a>";
		}
		mysqli_free_result($lsu);
		}
    }
	}
	
	echo "<p><a href='scommesseUtente.php'>Visualizza le tue scommesse</a></p>";
    mysqli_free_result($result);
}
else
{
    echo "Accedi per poter scommettere";
}
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();
echo "<p><a href='../../'> Torna indietro </a></p>";
?>
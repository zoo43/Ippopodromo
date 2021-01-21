<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="refresh" content= "5; url=scommetti.php">
</head>
<body>
<?php
require_once('../database.php');
session_Start();

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn)
{
	if(isset($_SESSION['username']))
	{
		if($dbAccess->aggiuntaScommessa($_SESSION['username'],$_POST['numeroGara'],$_POST['numeroCavallo'],$_POST['valorePuntata']))
		{
			echo('Il pagamento è avvenuto con successo');
		}else
		{
			echo '<script type="text/javascript">';
			echo 'alert("Si è verificato un errore imprevisto. Si prega di attendere prima di riprovare.")';
			echo '</script>';
		}
	}
	$dbAccess->closeDBConnection();
}
echo "<p><a href='scommetti.php'> Torna a scommettere </a></p>";
?>
</body>
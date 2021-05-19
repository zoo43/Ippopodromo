<!DOCTYPE HTML>
<html>
<head>
<!-- <meta http-equiv="refresh" content= "5; url=scommetti.php"> -->
</head>
<body>
<?php
require_once('../database.php');
require_once('../auth.php');

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn)
{
	if(isset($_SESSION['username']))
	{
		if($dbAccess->aggiuntaScommessa($_SESSION['username'],$_POST['numeroGara'],$_POST['numeroCavallo'],$_POST['valorePuntata']))
		{
			$row = $dbAccess->getCreditoUtente($_SESSION['username']);
			$_SESSION['credito'] = mysqli_fetch_array($row)['credito'];
			echo('Il pagamento è avvenuto con successo');
		}else
		{
			echo 'Si è verificato un errore imprevisto. Si prega di attendere prima di riprovare.';
		}
	}
	$dbAccess->closeDBConnection();
}
echo "<p><a href='scommetti.php'> Torna a scommettere </a></p>";
?>
</body>
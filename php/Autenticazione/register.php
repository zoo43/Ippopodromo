<?php
require_once('../database.php');
require_once('../auth.php');

$risultato='';
if(isset($_POST['register'])){
    $birthDate = $_POST['date'];
	$birthDate = explode("-", $birthDate);
	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
	
	if($age>=18)
	{
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    if($dbAccess->verificaPresenza($_POST['username'], $_POST['mail'])){
        $_SESSION["error"] = 'Nome Utente o mail già occupati';
        header("location:register.php");
    }
    else{
        $dbAccess->inserisciUtente($_POST['username'],$_POST['password'], $_POST['name'], $_POST['surname'], $_POST['date'], $_POST['address'], $_POST['city'], $_POST['mail']);
        $_SESSION["username"] = $_POST['username'];
        $_SESSION["credito"] = "100";
        header("location:../../");
    }
    $dbAccess->closeDBConnection();
    }
	else{
		$_SESSION["error"] = 'Devi essere maggiorenne per usufruire di questo servizio';
		header("location:register.php");
	}
}
else{      
        if(isset($_SESSION["error"])){
            $risultato = $_SESSION["error"];
            unset($_SESSION["error"]);
        }
        
        if(isset($_SESSION['username'])){
            header('Location: ../../');
        }
}

$pagina = areaAutenticazione(file_get_contents('../../html/autenticazione/register.html'));
$pagina = str_replace("<risultato-verifica />",$risultato,$pagina);
echo $pagina;

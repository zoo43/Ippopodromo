<?php
require_once('../database.php');

session_Start();


if(isset($_POST['login'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
	if($conn)
	{
    $username = $_POST['username'];
    if($dbAccess->autentica($username, $_POST['password'])){
        $_SESSION["username"] = $username;
        $result = $dbAccess->getCredito($username);
        while($row = mysqli_fetch_array($result))
        {          
            $_SESSION["credito"] = $row['credito'];                                                            
        }
        header("location:../../");
    }
    else{
        $_SESSION["error"] = 'Nome Utente o password errati';
        header("location:login.php");
    }
	}else
	{
		printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
	}
	
    $dbAccess->closeDBConnection();
}
?>
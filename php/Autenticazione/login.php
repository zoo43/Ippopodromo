<?php
require_once('../auth.php');
require_once('../database.php');
if(isset($_POST['login'])){
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
	if($conn)
	{
    $username = $_POST['username'];
    $result = $dbAccess->autentica($username, $_POST['password']);
    if($result!=false){
        $_SESSION["username"] = $username;

        $row = mysqli_fetch_array($result);
        $_SESSION["credito"] = $row['credito'];
        if($row['admin'])
        {
            $_SESSION["admin"]=$row["admin"];
        }   
        header("location:../../");
    }
    else{
        $_SESSION["error"] = 'Nome Utente o password errati';
        header("location:login.php");
    }
    mysqli_free_result($result);
	}else
	{
		printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
	}
	
    $dbAccess->closeDBConnection();
}else{

$errori="";

if(isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    echo "<script language='javascript'>
    alert('Nome utente o password errati');
    </script>";
    unset($_SESSION["error"]);
}

$pagina = areaAutenticazione(file_get_contents('../../html/autenticazione/login.html'));
echo $pagina;

}
?>
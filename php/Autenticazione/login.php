<?php
require_once('../auth.php');
require_once('../database.php');

$risultato = '';

if (isset($_POST['login'])) {
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    if ($conn) {
        $username = $_POST['username'];
        $result = $dbAccess->autentica($username, $_POST['password']);
        if ($result != false) {
            $_SESSION["username"] = $username;

            $row = mysqli_fetch_array($result);
            $_SESSION["credito"] = $row['credito'];
            if ($row['admin']) {
                $_SESSION["admin"] = $row["admin"];
            }
            header("location:../../");
        } else {
            $_SESSION["error"] = 'Nome Utente o password errati';
            header("location:login.php");
        }
    } else {
        printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
    }

    $dbAccess->closeDBConnection();
} else {

    if (isset($_SESSION["error"])) {
        $risultato = $_SESSION["error"];
        unset($_SESSION["error"]);
    }

    if (isset($_SESSION['username'])) {
        header('Location: ../../');
    }
}



$pagina = areaAutenticazione(file_get_contents('../../html/autenticazione/login.html'));
$pagina = str_replace("<risultato-verifica />", $risultato, $pagina);
echo $pagina;

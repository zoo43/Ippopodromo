<?php
require_once('../database.php');
require_once('../auth.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$risultatoAggiunta = "";

if (isset($_POST['submit'])) {
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();

    if ($conn) {
        if ($dbAccess->evitaDoppioni($_POST['nome'])) {
            $target_dir = "../../images/";
            $target_file = $target_dir . basename($_FILES["img"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["img"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $risultatoAggiunta .= "<p class='inserimentoFallito'>Il file inserito non è un'immagine</p>";
                    $uploadOk = 0;
                }
            } // Check if file already exists
            if (file_exists($target_file)) {
                $risultatoAggiunta .= "<p class='inserimentoFallito'>Esiste già l'immagine di quel cavallo, sicuro di non averlo già inserito?</p>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["img"]["size"] > 500000) {
                $risultatoAggiunta .= "<p class='inserimentoFallito'>Immagine troppo grande";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $risultatoAggiunta .= "<p class='inserimentoFallito'>Formato $imageFileType non permesso.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $risultatoAggiunta .= "<p class='inserimentoFallito'>Risolvere i problemi col caricamento dell'immagine</p>";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    if ($dbAccess->caricaCavalli($_POST['nome'], $_POST['velocita'], $_POST['descrizione'], $_FILES["img"]["name"])) {
                        $risultatoAggiunta = "<p class='inserimentoRiuscito'>Cavallo inserito!</p>";
                    } else {
                        $risultatoAggiunta = "<p class='inserimentoFallito'>C'è stato un problema con db</p>";
                    }
                } else {
                    $risultatoAggiunta .= "<p class='inserimentoFallito'>Risolvere i problemi col caricamento dell'immagine</p>";
                }
            }
        } else {
            $risultatoAggiunta = "<p class='inserimentoFallito'><strong id='fancyName'>" . $_POST['nome'] . "</strong>: nome del cavallo già presente nel DB</p>";
        }
        $dbAccess->closeDBConnection();
    } else {
        $risultatoAggiunta = "<p class='inserimentoFallito'>Problema nel collegarsi al DB</p>";
    }
    $pagina = file_get_contents('../../html/admin/aggiungiCavallo.html');
    $pagina = str_replace("<risultato-inserimento />", $risultatoAggiunta, $pagina);
    $pagina = areaAutenticazione($pagina);
    echo $pagina;
    unset($_POST['submit']);
} else {
    $pagina = file_get_contents('../../html/admin/aggiungiCavallo.html');
    $pagina = str_replace("<risultato-inserimento />", "", $pagina);
    $pagina = areaAutenticazione($pagina);
    echo $pagina;
}

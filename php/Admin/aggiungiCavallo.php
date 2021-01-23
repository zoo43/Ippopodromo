<?php
require_once('../database.php');


if(isset($_POST['submit']))
{
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

if($conn)
{
    if($dbAccess->evitaDoppioni($_POST['nome']))
    {
        $target_dir = "../../images/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if($check !== false) {
        $uploadOk = 1;
        } else {
        echo "Il file inserito non è un'immagine";
        $uploadOk = 0;
        }
        }// Check if file already exists
        if (file_exists($target_file)) {
        echo "Esiste già l'immagine di quel cavallo, sicuro di non averlo già inserito?";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 500000) {
        echo "Immagine troppo grande";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo ", non permesso.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "C'è stato un problema";
        // if everything is ok, try to upload file
        } else 
        {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) 
            {
                if($dbAccess->caricaCavalli($_POST['nome'], $_POST['velocita'], $_POST['descrizione'], $_FILES["img"]["name"]))
                {echo "tutt'apposto";}
                else {echo "C'è stato un problema con db";}
            } 
            else {echo "C'è stato un problema";}
        }
    }
    else
    {
        echo "il nome del cavallo è già presente nel DB";
    }
echo "//Pulsante per tornare indietro";
$dbAccess->closeDBConnection();
}
else
{
    echo "Problema nel collegarsi al DB";
}
}
?>
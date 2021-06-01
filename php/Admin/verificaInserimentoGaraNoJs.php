<?php
require_once('../database.php');
session_start();
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
$risultato = '';
if(isset($_POST['register']))
{
    if($conn)
    {
        $hour = date('H:i:s');
        $date = date('Y-m-d');
        $inputD= $_POST['date'];
        $inputT=$_POST['time'];
        if($date > $inputD)
        {
            $risultato .= "<p class='inserimentoFallito'>La gara deve avvenire almeno oggi, non prima.</p>";
        }
        else
        {
            if($date == $inputD && $hour > $inputT)
            {
                $risultato .= "<p class='inserimentoFallito'>La gara non può partire nel passato!</p>";
            }
            else
            {
                if(isset($_POST['cavalli']))
                {
                    if(count($_POST['cavalli'])>=4)
                    {
                        if($dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']))
                        {
                            $risultato .= "<p class='inserimentoRiuscito'>Gara inserita con successo</p>";
                        }
                        else
                        {
                            $risultato .= "<p class='inserimentoFallito'>C'è stato un problema con l'aggiornamento del database.</p>";
                        }
                        $dbAccess->closeDBConnection();
                    }
                    else
                    {
                        $risultato .= "<p class='inserimentoFallito'>Non hai inserito un numero sufficiente di cavalli (almeno 4).</p>";
                    }
                }
                else
                {
                    $risultato .= "<p class='inserimentoFallito'>Non hai inserito cavalli.</p>";
                }
            }
        }
    }
    else{
        $risultato = "<p class='inserimentoFallito'>Problema di connessione al DB</p>";
    }

    $_SESSION['risultatoInserimento'] = $risultato;
    header("Location:aggiungiGara.php");
}

?>
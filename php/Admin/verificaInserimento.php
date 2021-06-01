<?php
require_once('../database.php');
session_start();
if(isset($_POST['register']))
{
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    $risultato = '';
    $array = $_POST['cavalli'];
    $parimerito=false;
    for($i=0; $i<count($array); $i++)
    {
        for($j=$i+1;$j<count($array); $j++)
        {
            if($j<count($array))
            {
                if($array[$i]==$array[$j])
                {
                    $parimerito=true;
                }
            }
        }
    }
    if($parimerito==true)
    {
        $risultato = "<p class='inserimentoFallito'>Più cavalli non possono avere la stessa posizione in classifica.</p>";

    }  
    else
    {
        if($conn)
        {
            $dbAccess->updateRisultati($_POST['cavalli'],$_SESSION["cavalli"], $_SESSION['idGara']);
            unset($_SESSION["cavalli"]);
            unset($_SESSION['idGara']);
            unset($_POST['register']);
            $dbAccess->closeDBConnection();
            $risultato = "<p class='inserimentoRiuscito'>Risultato inserito con successo.</p>";
        }
        else
        {
            $risultato = "<p class='inserimentoFallito'>C'é stato un problema nell'aggiornamento del database.</p>";
        }
    }
    $_SESSION['risultatoInserimento'] = $risultato;
    header("Location:aggiungiRisultati.php");
}

?>
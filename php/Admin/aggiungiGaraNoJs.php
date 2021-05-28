<?php 
require_once('../database.php');
require_once('../auth.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
}

$risultatiAggiunta = '';
$cavalli = '';
$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();


function stampaListaCavalli($dbAccess,$cavalli)
{
    $result = $dbAccess->getCavalli(true);
    while($row = mysqli_fetch_array($result))
    {                                                                       
        $id = $row['idCavallo'];
        $name = $row['nome'];
        $cavalli = $cavalli . "<input type='checkbox' onchange='controllaNumeroCavalli()' id='$id' name='cavalli[]' value='$id'><label for='$id'>$name</label>";
    }
    mysqli_free_result($result);
    return $cavalli;
}

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
            echo "La gara deve avvenire, almeno oggi, non prima";
            $cavalli=stampaListaCavalli($dbAccess, $cavalli);
        }
        else
        {
            if($hour > $inputT)
            {
                echo "La gara non può partire nel passato!";
                $cavalli=stampaListaCavalli($dbAccess, $cavalli);
            }
            else
            {
                if(isset($_POST['cavalli']))
                {
                    if(count($_POST['cavalli'])>=4)
                    {
                        if($dbAccess->caricaGare($_POST['date'], $_POST['time'], $_POST['cavalli']))
                        {
                            $risultatiAggiunta = "<p class='inserimentoRiuscito'>Gara inserita con successo</p>";
                            $cavalli=stampaListaCavalli($dbAccess, $cavalli);
                        }
                        else
                        {
                            $risultatoAggiunta .= "<p class='inserimentoFallito'>C'è stato un problema</p>";
                        }
                        $dbAccess->closeDBConnection();
                    }
                    else
                    {
                        echo "Non hai inserito un numero sufficiente di cavalli (Ne servono aleno 4)!";
                        $cavalli=stampaListaCavalli($dbAccess, $cavalli);
                    }
                }
                else
                {
                    echo "Devi inserire i cavalli!";
                    $cavalli=stampaListaCavalli($dbAccess, $cavalli);
                }
            }
        }
    }
    else{
        $risultatoAggiunta = "<p class='inserimentoFallito'>Problema di connessione al DB</p>";
    }
}
else
{
    if($conn)
    {
        $cavalli=stampaListaCavalli($dbAccess, $cavalli);
        $dbAccess->closeDBConnection();
    }
    else
    {
        printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
    }

}
$pagina = file_get_contents("../../html/admin/aggiungiGaraNoJs.html");
$pagina = str_replace(
    array("<risultati-inserimento />", "<cavalli />"),
    array($risultatiAggiunta, $cavalli), 
    $pagina
);
echo $pagina;
?>
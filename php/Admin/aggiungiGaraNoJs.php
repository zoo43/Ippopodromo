<?php 
    require_once('../database.php');
    require_once('../auth.php');
    
    if (!isset($_SESSION['admin'])) {
        header('Location: ../../');
    }
    
    $risultatoAggiunta = '';
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
            $cavalli = $cavalli . "<div class='flex-div'><input type='checkbox' id='$id' name='cavalli[]' value='$id' aria-label='$name'> <label for='$id'><span>$name</span></label></div>";
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
                $risultatoAggiunta .= "<p class='inserimentoFallito'>La gara deve avvenire almeno oggi, non prima.</p>";
                $cavalli=stampaListaCavalli($dbAccess, $cavalli);
            }
            else
            {
                if($date == $inputD && $hour > $inputT)
                {
                    $risultatoAggiunta .= "<p class='inserimentoFallito'>La gara non può partire nel passato!</p>";
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
                                $risultatoAggiunta = "<p class='inserimentoRiuscito'>Gara inserita con successo</p>";
                                $cavalli=stampaListaCavalli($dbAccess, $cavalli);
                            }
                            else
                            {
                                $risultatoAggiunta .= "<p class='inserimentoFallito'>C'è stato un problema con l'aggiornamento del database.</p>";
                            }
                            $dbAccess->closeDBConnection();
                        }
                        else
                        {
                            $risultatoAggiunta .= "<p class='inserimentoFallito'>Non hai inserito un numero sufficiente di cavalli (almeno 4).</p>";
                            $cavalli=stampaListaCavalli($dbAccess, $cavalli);
                        }
                    }
                    else
                    {
                        $risultatoAggiunta .= "<p class='inserimentoFallito'>Non hai inserito cavalli.</p>";
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
            $risultatoAggiunta = "Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.";
        }
        
    }
    $pagina = file_get_contents("../../html/admin/aggiungiGaraNoJs.html");
    $pagina = str_replace(
    array("<risultati-inserimento />", "<cavalli />"),
    array($risultatoAggiunta, $cavalli), 
    $pagina
    );
    $pagina = areaAutenticazione($pagina);
    echo $pagina;
?>
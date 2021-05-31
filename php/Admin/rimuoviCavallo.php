<?php
    require_once('../database.php');
    session_start();
    
    if (!isset($_SESSION['admin'])) {
        header('Location: ../../');
    }
    
    $url = $_SERVER['REQUEST_URI'];    
    $url_components = parse_url($url); 
    parse_str($url_components['query'], $params); 
    
    $dbAccess = new DBAccess();
    $conn = $dbAccess->openDBConnection();
    
    $ris='';
    $lista = '';
    if($conn)
    {
        
        if( $dbAccess->eliminaCavallo($params['value'])){
            $ris = "cavallo ritirato con successo";
        }
        else
        {
            $ris = "problema nel dialogo con il db (il cavallo potrebbe partecipare una gara e sarebbe quindi impossibile da eliminare)";
        }
        
        $result = $dbAccess->getCavalli(true);
        while($row = mysqli_fetch_array($result)) {
            $lista .= "<tr><td>" . $row['nome'] . "</td><td><a href='rimuoviCavallo.php?value=" . $row['idCavallo'] . "'>Elimina</td></tr>";
        }
        $_SESSION["risultatoEliminazione"] = $ris;
        header("Location: gestisciCavalli.php");
    }
    else
    {
        printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
    }
    $pagina = areaAutenticazione($pagina);
    $dbAccess->closeDBConnection();
?>
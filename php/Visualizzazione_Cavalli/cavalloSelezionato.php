<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$apertura =  '<div class= "init" style="background: url(\'../../images/';

$cavallo = '<div id="info-cavallo" class="card">';
$lista_gare = '<section id="gare-cavallo" class="contentbox">';

$lista_gare .= '<div class="headline"><h1>Gare Corse</h1></div>';

if($conn)
{
    $gareggiato=true;

    $result=$dbAccess->getInfoCavallo($params['value'],true);
    if(!$result){
        $result=$dbAccess->getInfoCavallo($params['value'],false);
        $gareggiato=false;
    }


    if($gareggiato)
    { 
        while($row = mysqli_fetch_array($result))
        {    
            $nome = $row['nome'];
            $immagine = $row['immagine'];
            $descrizione = $row['descrizione'];
            $fiducia = $row['fiducia'];
            $velocita = $row['velocita'];
            $lista_gare .= '<div class="text"><p>Data: ' . $row["dataGara"] . '     Posizione: ' . $row["posizione"] . '</p></div>';
        } 
        $Scavallo = '
        './/<img src="../../images/<foto-cavallo />" alt="<descrizione-cavallo />"/>
        '<div class="content">
        <div class="headline"> <h2><nome-cavallo /></h2> </div>
        <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
        <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
        <div class="text"> <p><descrizione-cavallo /></p>  </div>
        </div>';
        $Scavallo = str_replace(
            array(//"<foto-cavallo />",
                  "<descrizione-cavallo />", "<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />"),
            array(
                //$immagine,
                $descrizione, $nome, $fiducia, $velocita
            ),
            $Scavallo
        );
        $cavallo .= $Scavallo;
        $apertura .= $immagine . '\') no-repeat fixed; background-position: center; background-size: 100%;"> <h1>'. $nome .'</h1>';
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $lista_gare .= '<div class="text"><p>Questo cavallo non ha ancora partecipato a nessuna gara </p></div>';

        $Scavallo = '
        './/<img src="../../images/<foto-cavallo />" alt="<descrizione-cavallo />"/>
       '<div class="content">
        <div class="headline"> <h2><nome-cavallo /></h2> </div>
        <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
        <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
        <div class="text"> <p><descrizione-cavallo /></p>  </div>
        </div>';
        $Scavallo = str_replace(
            array(//"<foto-cavallo />",
                  "<descrizione-cavallo />", "<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />"),
            array(
                //$row['immagine'],
                $row['descrizione'], $row['nome'], $row['fiducia'], $row['velocita']
            ),
            $Scavallo
        );
        $cavallo .= $Scavallo;
        $apertura .= $row['immagine'] . '\') no-repeat fixed; background-position: center; background-size: 100%;"> <h1>'. $row['nome'] .'</h1>';
    }
    mysqli_free_result($result);
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$cavallo .= ' </div>';
$lista_gare .= ' </section>';
$apertura .= ' </div>';

$pagina = file_get_contents('../../html/cavalli/cavalloSelezionato.html');
$pagina = str_replace("<apertura-cavallo />", $apertura, $pagina);
$pagina = str_replace("<info-cavallo />", $cavallo, $pagina);
$pagina = str_replace("<gare-cavallo />", $lista_gare, $pagina);

echo $pagina;
?>
<?php
require_once('../database.php');
require_once('../auth.php');
$url = $_SERVER['REQUEST_URI'];
$url_components = parse_url($url);
parse_str($url_components['query'], $params);

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();

$cavallo = '<div id="info-cavallo" class="card">';
$lista_gare = '<section id="gare-cavallo" class="contentbox">';

$lista_gare .= '<div class="headline"><h1>Gare Corse</h1></div>';
$nome_cavallo= '';

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
        $lista_gare .= '<table>
                            <thead class="norm">
                                <tr>
                                    <th scope="col">Posizione</th>
                                    <th scope="col">Giorno</th>
                                    <th scope="col">Ora</th>
                                </tr>
                            </thead>
                            <tbody>';
        while($row = mysqli_fetch_array($result))
        {
            $nome = $row['nome'];
            $immagine = $row['immagine'];
            $descrizione = $row['descrizione'];
            $fiducia = $row['fiducia'];
            $velocita = $row['velocita'];
            $ritirato = $row['ritiro'] == 1 ? "(ritirato)" : "";
            $arr=explode(" ",$row['dataGara']);
            $giorno = $arr[0];
            $ora=$arr[1];
            $lista_gare .= '<tr>
                                <td data-label="Posizione"> '.$row["posizione"].'</td>
                                <td data-label="Data"> '.$giorno.'</td>
                                <td data-label="Ora"> '.$ora.'</td>
                            </tr>';
            //$lista_gare .= '<div class="text"><p>Data: ' . $row["dataGara"] . '     Posizione: ' . $row["posizione"] . '</p></div>';
        }


        $lista_gare.= '</tbody>
                        </table>';

        $Scavallo = '
        <img src="../../images/<foto-cavallo />" alt="<descrizione-cavallo />"/>
        <div class="content">
        <div class="headline"> <h2><nome-cavallo /> <ritirato /></h2> </div>
        <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
        <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
        <div class="text"> <p><descrizione-cavallo /></p>  </div>
        </div>';
        $Scavallo = str_replace(
            array("<foto-cavallo />",
              "<descrizione-cavallo />", "<nome-cavallo />", "<ritirato />", "<fiducia-cavallo />", "<velocita-cavallo />"),
            array(
                $immagine,
                $descrizione, $nome, $ritirato, $fiducia, $velocita
            ),
            $Scavallo
        );
        $cavallo .= $Scavallo;
        $nome_cavallo = $nome;
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $lista_gare .= '<div class="text"><p>Questo cavallo non ha ancora partecipato a nessuna gara </p></div>';

        $Scavallo = '<img src="../../images/<foto-cavallo />" alt="<descrizione-cavallo />"/>
        <div class="content">
        <div class="headline"> <h2><nome-cavallo /></h2> </div>
        <div class="text"> <h3>Fiducia: <fiducia-cavallo /></h3> </div>
        <div class="text"> <h3>Velocità: <velocita-cavallo /></h3>  </div>
        <div class="text"> <p><descrizione-cavallo /></p>  </div>
        </div>';
        $Scavallo = str_replace(
            array("<foto-cavallo />",
              "<descrizione-cavallo />", "<nome-cavallo />", "<fiducia-cavallo />", "<velocita-cavallo />"),
            array(
                $row['immagine'],
                $row['descrizione'], $row['nome'], $row['fiducia'], $row['velocita']
            ),
            $Scavallo
        );
        $cavallo .= $Scavallo;
        $nome_cavallo = $row['nome'];
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

$pagina = file_get_contents('../../html/cavalli/cavalloSelezionato.html');

$pagina = str_replace("<nome-cavallo />", $nome_cavallo, $pagina);
$pagina = str_replace("<info-cavallo />", $cavallo, $pagina);
$pagina = str_replace("<gare-cavallo />", $lista_gare, $pagina);
$pagina = areaAutenticazione($pagina);

echo $pagina;
?>

<?php
require_once('../database.php');
$url = $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url); 
parse_str($url_components['query'], $params); 

$classifica = '';
$partecipanti = '';

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
    $result=$dbAccess->getInfoGara($params['value']);
    
    while($row = mysqli_fetch_array($result))
    {
        $data = $row['dataGara'];
        $partecipanti .= '<li><a href="../Visualizzazione_Cavalli/cavalloSelezionato.php?value=' . $row ['idCavallo'] . '">' . $row['nome'] . '</a></li>';
        if($row['stato'] == 2)
        {
            $stato = "Conclusa";
            $classifica .= '<tr><td>' . $row['posizione'] . '</td><td>' . $row['nome'] . '</td></tr>';
        }
        else {
            $stato = "In corso";
            $classifica = '<tr><td colspan="2">Attendi la fine della gara per vedere la classifica finale.</td></tr>';
        }
    }
}
else
{
	printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
}
$dbAccess->closeDBConnection();

$meta_title = '<meta name="title" content="Classifica gara del ' . $data . '" />';

$pagina = file_get_contents('../../html/gare/garaSelezionata.html');
$pagina = str_replace(
    array("<data-gara />", "<meta-title-gara />", "<stato-gara />", "<classifica-gara />", "<partecipanti />"),
    array($data, $meta_title, $stato, $classifica, $partecipanti),
    $pagina
);

echo $pagina;

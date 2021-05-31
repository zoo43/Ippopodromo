<?php
require_once('../database.php');
require_once('../auth.php');


$lista_gare = "";

$dbAccess = new DBAccess();
$conn = $dbAccess->openDBConnection();
if($conn)
{
    $result = $dbAccess->getGare("2");
    if(isset($result))
    {
        while($row = mysqli_fetch_array($result))
        {
        	$arr=explode(" ",str_replace('-','/', $row["dataGara"]));
            $giorno = $arr[0];
            $ora=$arr[1];

          //   $lista_gare .= '<tr>
      				// 			<td data-label="ID"><a href="garaSelezionata.php?value='.$row['idGara'].'"> '.$row['idGara'].' </a></td>
      				// 			<td data-label="Data Gara"><a href="garaSelezionata.php?value='.$row['idGara'].'"> '.$giorno.'</a></td>
      				// 			<td data-label="Ora Gara"><a href="garaSelezionata.php?value='.$row['idGara'].'">'.$ora.'</a></td>
    						// </tr>';

    		$lista_gare .= '<div class="card">
    			 <div class="content">
	    			 <div class="headline"> <h2>Gara '.$row['idGara'].' </h2> </div>
		        	 <div class="text"> <h3>Giorno: '.$giorno.'</h3> </div>
		        	 <div class="text"> <h3>Ora: '.$ora.'</h3>  </div>
		        	 <a href="garaSelezionata.php?value='.$row['idGara'].'"><div class="button"> <h4>Informazioni</h4> </div></a>
	          	 </div>
        	 </div>';
        }
    }
    else {
        $lista_gare = '<h1> Ancora nessuna gara si é conclusa </h1>';
    }
    mysqli_free_result($result);
}
else
{
	$lista_gare = '<h1> Si è verificato un errore di connessione. Si prega di attendere prima di riprovare. </h1>';
}
$dbAccess->closeDBConnection();

$pagina = file_get_contents('../../html/gare/risultati.html');
$pagina = str_replace(
    array("<lista-gare />"),
    array($lista_gare),
    $pagina
);
$pagina = areaAutenticazione($pagina);

echo $pagina;
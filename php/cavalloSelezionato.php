<?php
require_once('database.php');
 $url = $_SERVER['REQUEST_URI'];    
 $url_components = parse_url($url); 
 parse_str($url_components['query'], $params); 
      

 $dbAccess = new DBAccess();
 $conn = $dbAccess->openDBConnection();
 $result=$dbAccess->getInfoCavallo($params['value']);
 while($row = mysqli_fetch_array($result))
{
    //Da mettere immagine, risultati, ecc
    print($row[0]);
    print($row[1]);
}
 $dbAccess->closeDBConnection();
?>
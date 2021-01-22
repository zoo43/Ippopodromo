<?php

class DBAccess{   
   private const SERVERNAME =  "localhost" ;
   private const USERNAME = "root";
   private const PASSWORD = "";
   private const DBNAME = "ippopodromo";
   private $connection;


   //Connessioni
   public function openDBConnection(){

      if(!(mysqli_connect(DBAccess::SERVERNAME, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DBNAME))){
            return false;
       }
       else{
            $this->connection = mysqli_connect(DBAccess::SERVERNAME, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DBNAME);
           return true;
       }

   }

   public function closeDBConnection(){
        mysqli_close($this->connection);
   }

   
   //Registrazione
   public function verificaPresenza($username, $mail)
   {
        $query = "SELECT * from Utente where nomeUtente='$username' or mail='$mail'";

        $result = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($result)>0){
            mysqli_free_result($result);
            return true;
        }
        else{
            mysqli_free_result($result);
            return false;
        }
   }

   public function inserisciUtente($username, $password, $name, $surname, $date, $address, $city, $mail)
   {
       $query = "INSERT INTO Utente (nomeUtente, nome, cognome, dataNascita, indirizzo, citta, credito, password, mail, admin) VALUES
       ('$username', '$name', '$surname', '$date', '$address', '$city', '100', '$password', '$mail', '0')";

       mysqli_query($this->connection, $query);

       if(mysqli_affected_rows($this->connection)>0){
           return true;
       }
       else{
           return false;
       }
   }

   //Login

   public function autentica($nome, $password)
   {   
       $query = "SELECT * from Utente where nomeUtente='$nome' and password='$password'";

       $result = mysqli_query($this->connection, $query);
       
       if(mysqli_affected_rows($this->connection)>0){
           return $result;
       }
       else{
            mysqli_free_result($result);
           return false;
       }
   }

   
   function getCavalli()
   {
       $query = "SELECT * from cavallo";
       $result = mysqli_query($this->connection, $query);
       return $result;
   }

   public function getInfoCavallo($id,$cavalloNuovo)
   {
       if($cavalloNuovo)
       {
           $query = "SELECT cavallo.idCavallo, descrizione, posizione, dataGara, nome, immagine, fiducia, stanchezza, velocita FROM (cavallo INNER JOIN partecipante ON cavallo.idCavallo = partecipante.idCavallo)
           INNER JOIN gara ON gara.idGara=partecipante.idGara
           WHERE cavallo.idCavallo = '$id' AND gara.stato=2";
           $result = mysqli_query($this->connection, $query);
           if(mysqli_affected_rows($this->connection)>0)
           {
               return $result;
           }
           else
           {  mysqli_free_result($result); return false;}
       }
       else
       {
           $query = "SELECT idCavallo, descrizione, nome, immagine, velocita, fiducia FROM cavallo WHERE cavallo.idCavallo = '$id'";
           $result = mysqli_query($this->connection, $query);
           return $result;
       }
   }


   //Risultati
   public function getGare($stato)
   {
        if($stato == 2)
        {
            $query = "SELECT dataGara, idGara from Gara where stato=$stato";
            $result = mysqli_query($this->connection, $query);
            return $result;
        }
        else
        {
            $query = "SELECT dataGara, idGara from Gara where stato=$stato and dataGara< " . "'".date('Y-m-d H:i:s') ."'";
            $result = mysqli_query($this->connection, $query);
            return $result;
        }
   }

   public function getInfoGara($id)
   {
        $query = "SELECT dataGara, nome, cavallo.idCavallo, posizione, stato from gara inner join partecipante on gara.idGara=partecipante.idGara inner join cavallo on cavallo.idCavallo=partecipante.idCavallo where partecipante.idGara=$id order by posizione";
        $result = mysqli_query($this->connection, $query);
        return $result;
   }


   //Admin
   public function caricaGare($date,$time,$arr)
   {
        $query = "INSERT INTO gara (dataGara,stato) VALUES('$date $time', '0')";

        mysqli_query($this->connection, $query);


        $query = "SELECT max(idGara) from gara";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        $id=$row[0];

        if(mysqli_affected_rows($this->connection)>0){
        for ($i = 0; $i < count($arr) ; $i++) {
            
            $string = $arr[$i];
            $query = "INSERT INTO partecipante (idGara,idCavallo) VALUES('$id','" . $string . "')"; 
            mysqli_query($this->connection, $query);
        }
        mysqli_free_result($result);
        return true;
       }
       else{
        mysqli_free_result($result);
           return false;
       }
   }

   public function caricaCavalli($nome,$velocita,$descrizione, $img)
   {
        $query = "INSERT INTO cavallo (nome,velocita,descrizione,immagine, fiducia,stanchezza) VALUES('$nome', '$velocita', '$descrizione','$img',15,0)";

        mysqli_query($this->connection, $query);
        if(mysqli_affected_rows($this->connection)>0){
        return true;
       }
       else{
           return false;
       }
   }

   public function getCavalliGara($idGara)
   {
    $query = "SELECT cavallo.idCavallo, descrizione, nome from cavallo inner join partecipante on cavallo.idCavallo=partecipante.idCavallo where idGara=$idGara";
    $result = mysqli_query($this->connection, $query);
    return $result;
   }

   public function updateRisultati($posizioni, $idCavalli, $idGara)
   {
       $bool = false;
        for($i=0;$i<count($posizioni);$i++)
        {
            $query = "UPDATE partecipante SET posizione" . "=". $posizioni[$i]." WHERE idGara='$idGara' AND idCavallo='". $idCavalli[$i]['id'] ."'";
            mysqli_query($this->connection, $query);
            if(mysqli_affected_rows($this->connection)>0){
                $bool=true;
            }
            else{
                $bool = false;
            }
        }

        $query = "UPDATE gara SET stato='2' where idGara='$idGara'"; 
        mysqli_query($this->connection, $query);
        if(mysqli_affected_rows($this->connection)>0){
            $bool = true;
        }
        else{
            $bool = false;
        }
        return $bool;
   }
   

   //Scommesse

	public function getCreditoUtente($username)
	{
		$query = "SELECT credito FROM utente WHERE nomeUtente='".$username."'";
		$result = mysqli_query($this->connection, $query);
		return $result;
	}
	
	public function getScommesseUtente($username)
	{
		$query = "SELECT DISTINCT scommessa.idGara,scommessa.idCavallo, dataGara, cavallo.nome,puntata FROM scommessa INNER JOIN partecipante ON scommessa.idGara = partecipante.idGara INNER JOIN cavallo ON scommessa.idCavallo = cavallo.idCavallo INNER JOIN gara ON partecipante.idGara = gara.idGara WHERE nomeUtente='".$username."'";
		$result = mysqli_query($this->connection, $query);
		return $result;
	}

    public function updateDopoPagamento($username, $costo)
	{
	   $query = "UPDATE utente SET credito"."=credito-".$costo." WHERE nomeUtente='".$username."'";
	   if($this->connection->query($query))
	   {
		  return true;
	   }
	   else
	   {
		  return false;
	   }
    }

	
	public function aggiuntaScommessa($username, $idGara, $idCavallo, $puntata)
	{
		$query = "INSERT INTO scommessa(idGara, idCavallo, nomeUtente, puntata) VALUES ('".$idGara."','".$idCavallo."','".$username."','".$puntata."')";
		if($this->connection->query($query))
		{
			return $this->updateDopoPagamento($username, $puntata); 
		}
		else
		{
			return false;
		}
	}
	
	public function confermaScommesse($idGara)
	{
		$noError = true;
		$query = "SELECT * FROM scommessa WHERE idCavallo=(SELECT idCavallo FROM partecipante WHERE idGara=".$idGara." AND posizione=1) AND idGara=".$idGara." AND stato=0";
		$resultQuery = mysqli_query($this->connection, $query);
		while($row = mysqli_fetch_array($resultQuery))
		{
			$toAdd = $row['puntata']*2;
			$queryUpdateCredito = "UPDATE utente SET credito"."=credito+".$toAdd." WHERE nomeUtente"." ='".$row['nomeUtente']."'";
			if($this->connection->query($queryUpdateCredito))
			{
				$queryUpdateStatoScommessa = "UPDATE scommessa SET stato=1 WHERE nomeUtente='".$row['nomeUtente']."' AND idGara=".$idGara;
				if($this->connection->query($queryUpdateStatoScommessa))
				{
                    mysqli_free_result($resultQuery);
					return true;
				}
				else{
                    mysqli_free_result($resultQuery);
					return false;
				}
			}
			else{
                mysqli_free_result($resultQuery);
				return false;
			}
        }
        mysqli_free_result($resultQuery);
		return false;
	}
}
	
?>
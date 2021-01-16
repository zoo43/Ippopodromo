<?php

class DBAccess{   
   private const SERVERNAME =  "localhost" ;
   private const USERNAME = "root";
   private const PASSWORD = "";
   private const DBNAME = "ippopodromo";
   private $connection;


   //Connessioni
   public function openDBConnection(){
       $this->connection = mysqli_connect(DBAccess::SERVERNAME, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DBNAME);
      if(!($this->connection)){
			return false;
       }
       else{
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
            return true;
        }
        else{
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
           return false;
       }
   }

   
   function getCavalli()
   {
       $query = "SELECT * from cavallo";
       $result = mysqli_query($this->connection, $query);
       return $result;
   }

   public function getInfoCavallo($id)
   {
       $query = "SELECT cavallo.idCavallo,descrizione, posizione, dataGara,nome, immagine, fiducia, stanchezza, velocita FROM (cavallo INNER JOIN partecipante ON cavallo.idCavallo = partecipante.idCavallo)
       INNER JOIN gara ON gara.idGara=partecipante.idGara
       WHERE cavallo.idCavallo = '$id' AND gara.stato=2";
       $result = mysqli_query($this->connection, $query);
       return $result;
   }


   //Risultati
   public function getGare($stato)
   {
       $query = "SELECT dataGara, idGara from Gara where stato=$stato";
       $result = mysqli_query($this->connection, $query);
       return $result;
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
            echo $query;
        }
       }
       else{
           return false;
       }
   }

}
?>
<?php
class DBAccess{
   private const SERVERNAME =  "localhost" ;
   private const USERNAME = "root";
   private const PASSWORD = "";
   private const DBNAME = "ippopodromo";
   private $connection;

   public function openDBConnection(){
       $this->connection = mysqli_connect(DBAccess::SERVERNAME, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DBNAME);
      if(mysqli_connect_errno($this->connection)){
           return false;
       }
       else{
           return true;
       }
   }

   public function closeDBConnection(){
        mysqli_close($this->connection);
   }

   public function inserisciUtente()
   {
       $query = "INSERT INTO Utente (nomeUtente, nome, cognome, dataNascita, indirizzo, citta, credito, password, mail, admin) VALUES
       ('adminsasd', 'Gianlucasasdas', 'Innusa', '1999-12-25', 'Via degli Admin 33', 'Castelfranco Veneto', '9999', 'adminsasd', 'matteo16.martini@outlook.it', '1')";

       mysqli_query($this->connection, $query);

       if(mysqli_affected_rows($this->connection)>0){
           return true;
       }
       else{
           return false;
       }
   }

   public function verificaUtente($nome, $password)
   {
       
       $query = "SELECT * from Utente where nomeUtente='$nome' and password='$password'";

       $result = mysqli_query($this->connection, $query);
       
       if(mysqli_affected_rows($this->connection)>0){
           return true;
       }
       else{
           return false;
       }

   }
}
?>
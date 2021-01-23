<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">

<script type="text/javascript">
            function validazioneInput()
            {
                var maggiorenne = document.getElementById('date').value;
				if(calculate_age(new Date(maggiorenne)))
				{
					return true;
				}
				else
				{
					alert('Per poterti iscrivere a questo servizio devi avere più di 18 anni');
					return false;
				}
            }
			
			function calculate_age(dob) { 
				var diff = Date.now() - dob.getTime();
				var age = new Date(diff); 
				var maggiorenne = Math.abs(age.getUTCFullYear() - 1970);
				if(maggiorenne>=18)
				{
					return true;
				}
				else
				{
					return false;
				}
            }
        </script>
</head>
<body>
    <form method="post" onsubmit="return validazioneInput()" action="check.php" id="register">
    <form method="post" onsubmit="return validazioneInput()" action="check.php">
        <h1>Registrazione</h1>
        <input type="text" id="username" placeholder="Nome Utente" name="username" maxlength="50" required>
        <input type="password" id="password" placeholder="Password" name="password" minlength="6" required>
        <input type="text" id="name" placeholder="Nome" name="name" maxlength="50" required>
        <input type="text" id="surname" placeholder="Cognome" name="surname" maxlength="50" required>
        
        <input type="date" id="date" placeholder="Data di Nascita" name="date" required>
        
        <input type="text" id="address" placeholder="Indirizzo" name="address" maxlength="50" required>
        <input type="text" id="city" placeholder="Città" name="city" maxlength="50" required>
        <input type="text" id="mail" placeholder="Mail" name="mail" pattern="[a-zA-Z0-9]+[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]{0,}[a-zA-Z0-9]{0,}@[a-zA-Z0-9]{3,}\.[a-zA-Z]{2,3}$" maxlength="50" required>

        <button type="submit" name="register">Registrati</button>
        <?php        
        if(isset($_SESSION["error"])){
            $error = $_SESSION["error"];
            echo '<script language="javascript">';
            echo "alert('Nome utente o mail già presenti nel database')";
            echo '</script>';
        }
        ?>
    </form>
    <p><a href="../../"> Torna Indietro </a></p>
</body>
</html>

<?php
unset($_SESSION["error"]);
?>
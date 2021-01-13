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
                var a = document.forms["Form"]["date"].value;
                var b = document.forms["Form"]["mail"].value;
                //Mancano da definire controlli (tipo date e mail)
            }
        </script>
</head>
<body>
    <form method="post" onsubmit="return validazioneInput()" action="checkRegister.php">
        <h1>Registrazione</h1>
        <input type="text" id="username" placeholder="Nome Utente" name="username" maxlength="50" required>
        <input type="password" id="password" placeholder="Password" name="password" required>
        <input type="text" id="name" placeholder="Nome" name="name" maxlength="50" required>
        <input type="text" id="surname" placeholder="Cognome" name="surname" maxlength="50" required>
        
        <input type="date" id="date" placeholder="Data di Nascita" name="date" maxlength="50" required>
        
        <input type="text" id="address" placeholder="Indirizzo" name="address" maxlength="50" required>
        <input type="text" id="city" placeholder="Città" name="city" maxlength="50" required>
        <input type="text" id="mail" placeholder="Mail" name="mail" maxlength="50" required>

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
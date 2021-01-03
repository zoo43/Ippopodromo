<?php
session_start();
?>


<!DOCTYPE html>
<html> 
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    
    <form method="post" name="Form" action="checkLogin.php">
    <h1>Login</h1>
    <input type="text" id="username" placeholder="Username" name="username" required>
    <input type="password" id="password" placeholder="Password" name="password" required>
    <button type="submit" name="login">Accedi</button>
    <?php
        if(isset($_SESSION["error"])){
            $error = $_SESSION["error"];
            echo '<script language="javascript">';
            echo "alert('Nome utente o password errati')";
            echo '</script>';
        }
    ?>
</form>
<p><a href="../../"> Torna Indietro </a></p>
</html>

<?php
unset($_SESSION["error"]);
?>

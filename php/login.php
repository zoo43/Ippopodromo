<?php
session_start();
?>


<!DOCTYPE html>
<html> 
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript">
            function validazioneInput()
            {
                var a = document.forms["Form"]["username"].value;
                var b = document.forms["Form"]["password"].value;
                if(a=="" || b==""){
                    alert ("Nome Utente o password mancanti");
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>
    </head>
    
    <form method="post" name="Form" onsubmit="return validazioneInput()" action="check.php">
    <h1>Login</h1>
    <input type="text" id="username" placeholder="Username" name="username">
    <input type="password" id="password" placeholder="Password" name="password">
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
</html>

<?php
unset($_SESSION["error"]);
?>

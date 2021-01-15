<!DOCTYPE html>
<html lang="it">

<head>
    <title>Aggiungi Gara</title> <!-- nitrito hihihihi -->
    <meta name="title" content="aggiungi-gara" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" type="text/css" href="style/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="style/small.css" media="" />
    <link rel="stylesheet" type="text/css" href="style/print.css" media="print" />
</head>

<body>
    <header>
        <div id="breadcrumb">
            <!-- potrebbe essere inutile dato dato che non abbiamo molto da andare in profonditá-->
            <ul>
                <li lang="en">Aggiungi Gara</li>
            </ul>
        </div>
        <nav id="menu">
            <ul>
                <li lang="en"><a href="../">Home</a></li>
                <li><a href="../php/Visualizzazione_Gare/risultati.php">Gare</a></li>
                <li><a href="../php/Visualizzazione_Cavalli/cavalli.php">Cavalli</a></li>
            </ul>
        </nav>
        <img src="../images/logo.jpg" alt="logo ippodromo rimuovi questo alt" />
    </header>
    <section>
        <form method="post" onsubmit="return validazioneInput()" action="../php/Admin/aggiungiGara.php">
            <h1>Scegli i dati della gara!</h1>         
            <input type="date" id="date" name="date" required>
            <input type="time" id="time" name="time" min="08.00.00" required>
            <?php
            require_once('../php/database.php');
            $dbAccess = new DBAccess();
            $conn = $dbAccess->openDBConnection();
            if($conn)
            {
                $result = $dbAccess->getCavalli();
                while($row = mysqli_fetch_array($result))
                {                                                                       
                    $id = $row['idCavallo'];
                    $name = $row['nome'];
                    print("<input type='checkbox' id='$id' name='$name'> <label for='$name'>$name</label>");
                }
            }
            else
            {
	            printf("Si è verificato un errore di connessione. Si prega di attendere prima di riprovare.");
            }
            $dbAccess->closeDBConnection();

            ?>
            <button type="submit" name="register">Inserisci</button>
        </form>
    </section>
    <footer>
        <img id="img-valid-code" src="images/valid-xhtml10.png" alt="HTML valido" />
        <img id="img-valid-css" src="images/vcss-blue.gif" alt="CSS valido" /> <!-- cambiare src dopo aver validato -->
    </footer>
</body>

</html>

<script>
var date = new Date();
var currentDate = date.toISOString().slice(0,10);

var ora = date.getHours()+1;
var minuti = date.getMinutes();
if (date.getHours()+1 < 10) {
    ora = "0" + ora;
}
if (date.getMinutes() < 10) {
    minuti = "0" + minuti;
}
var currentTime = ora + ':' + minuti;

document.getElementById('date').setAttribute("min", currentDate);

var min = "08:00:00";
var max = "22:00:00";
document.getElementById('time').setAttribute("value", currentTime);
document.getElementById('time').setAttribute("min", min);
document.getElementById('time').setAttribute("max", max);
</script>

<?php

session_Start();
unset($_SESSION["username"]);
header("location:../../");

?>
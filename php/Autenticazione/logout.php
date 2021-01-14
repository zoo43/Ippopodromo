<?php

session_Start();
unset($_SESSION["username"]);
unset($_SESSION["admin"]);
header("location:../../");

?>
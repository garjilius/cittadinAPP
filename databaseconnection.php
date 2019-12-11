<?php

$username = "cittadinapp";
$host = "localhost";
$database = "my_cittadinapp";
$myip = $_SERVER["REMOTE_ADDR"];

$db = mysql_connect($host, $username) or die("Errore durante la connessione al database");
mysql_select_db($database, $db) or die("Errore durante la selezione del database");
?>

<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$CF = $_GET['CF'];

$query = "SELECT * FROM Utente WHERE CF = '".$CF."'";

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'; 
include 'databaseconnection.php';
$response = mysql_query($query) or die ("Impossibile fare la query");

echo '<dati>';
while ($riga = mysql_fetch_assoc($response)) {
echo '<Utente>';

echo '<CF>'.$riga["CF"].'</CF>';
echo '<password>'.$riga["password"].'</password>';
echo '<tipoUtente>'.$riga["tipoUtente"].'</tipoUtente>';
echo '<nome>'.$riga["nome"].'</nome>';
echo '<cognome>'.$riga["cognome"].'</cognome>';
echo '<dataNascita>'.$riga["dataNascita"].'</dataNascita>';
echo '<attendibilita>'.$riga["attendibilita"].'</attendibilita>';

echo '</Utente>';
}
echo '</dati>';
?>

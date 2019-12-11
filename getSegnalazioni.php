<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$str_query = $_GET['query'];


echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'; 
include 'databaseconnection.php';
$response = mysql_query($str_query) or die ("Impossibile fare la query");



echo '<dati>';
while ($riga = mysql_fetch_assoc($response)) {
echo '<Segnalazione>';

echo '<id>'.$riga["id"].'</id>';
echo '<luogo>'.$riga["via"].", ".$riga["numeroCivico"].", ".$riga["citta2"].", ".$riga["provincia"].", ".$riga["regione"].'</luogo>';
echo '<descrizione>'.$riga["descrizione"].'</descrizione>';
echo '<attendibilita>'.$riga["attendibilita"].'</attendibilita>';
echo '<stato>'.$riga["stato"].'</stato>';
echo '<cfOperatore>'.$riga["cfOperatore"].'</cfOperatore>';
echo '<dataChiusura>'.$riga["dataChiusura"].'</dataChiusura>';

echo '</Segnalazione>';
echo '<Extra>';

echo '<id>'.$riga["id"].'</id>';
echo '<livello>'.$riga["livello"].'</livello>';
echo '<cfSegnalatore>'.$riga["CF"].'</cfSegnalatore>';

echo '</Extra>';
}
echo '</dati>';

?>
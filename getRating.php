<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include 'databaseconnection.php';

$CF = $_GET['CF'];
$cfOperatore = $_GET['cfOperatore'];
$stato = $_GET['stato'];
$id = $_GET['id'];

$queryTotali = "SELECT COUNT(*) FROM Segnalazione WHERE CF = '" . $CF . "' AND cfOperatore IS NOT NULL";
$queryPositive = "SELECT COUNT(*) FROM Segnalazione WHERE CF = '" . $CF . "' AND stato = 1";
$queryAVG ="SELECT AVG(valutazione) FROM Segnalazione WHERE CF = '" . $CF . "' AND cfOperatore IS NOT NULL";
$queryRiscontri ="SELECT COUNT(*) FROM Segnalazione WHERE CF = '" . $CF . "' AND (stato = 1 OR stato = 2)";

$queryUpdateStato = "UPDATE Segnalazione SET stato = ".$stato.", cfOperatore = '".$cfOperatore."', dataChiusura = CURDATE() WHERE id = ".$id;

$responseUpdateStato = mysql_query($queryUpdateStato) or die ($queryUpdateStato);

sleep(1); //IMPORTANTE

$responseTotali = mysql_query($queryTotali) or die ("Impossibile fare la query totali");
$responsePositive = mysql_query($queryPositive) or die ("Impossibile fare la query positive");
$responseAVG = mysql_query($queryAVG) or die ("Impossibile fare la query avg");
$responseRiscontri = mysql_query($queryRiscontri) or die ("Impossibile fare la query riscontri");

sleep(1); //IMPORTANTE!!!

$totali = mysql_fetch_row($responseTotali);
$positive =  mysql_fetch_row($responsePositive);
$AVG =  mysql_fetch_row($responseAVG);
$riscontri =  mysql_fetch_row($responseRiscontri);

$segnalazioniConRiscontro = $riscontri[0];
$segnalazioniTotali = $totali[0];
$segnalazioniPositive = $positive[0];
$segnalazioniAVG = $AVG[0] / 100;

$pesoQuantita = 0.6;
$pesoQualita = 0.4;

$hitRate = $segnalazioniPositive / $segnalazioniConRiscontro;
$rating = ($hitRate * $pesoQuantita + $segnalazioniAVG * $pesoQualita) * 100;

if($segnalazioniConRiscontro<3 && $segnalazioniAVG<0.7) {
    $rating = -1;
}

$queryUpdateRating = "UPDATE Utente SET attendibilita = '".$rating."' WHERE CF = '" . $CF . "'";
$responseUpdateRating =  mysql_query($queryUpdateRating) or die ("Impossibile fare la query");

//sleep(1); //IMPORTANTE

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'; 

echo '<dati>';

echo '<totali>'.$segnalazioniTotali.'</totali>';
echo '<conRiscontro>'.$segnalazioniConRiscontro.'</conRiscontro>';
echo '<positive>'.$segnalazioniPositive.'</positive>';
echo '<hitRate>'.$hitRate.'</hitRate>';
echo '<AVG>'.$segnalazioniAVG.'</AVG>';
echo '<rating>'.$rating.'</rating>';

echo '</dati>';
?>
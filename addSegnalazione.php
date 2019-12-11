<?php
require_once './databaseconnection.php';

if(isset($_POST['cf']) && isset($_POST['coordinate']) && isset($_POST['luogo']) && isset($_POST['descrizione'])) {
    
    $cf = $_POST['cf'];
    $coordinate = $_POST['coordinate'];
    $luogo = $_POST['luogo'];
    $descrizione = $_POST['descrizione'];
    
    $query = "SELECT attendibilita FROM Utente WHERE CF = '%s'";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $riga = mysql_fetch_row($result);
    $attendibilita = $riga[0];

    $nuovaQuery = "INSERT INTO Segnalazione VALUES (NULL,'%s','%s', '%s','%s',0,'%s', NOW())";
    $nuovaQuery = sprintf($nuovaQuery, $descrizione, $luogo, $coordinate, $attendibilita, $cf);
    echo $result = mysql_query($nuovaQuery);
    
}


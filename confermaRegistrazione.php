<?php

require_once './databaseconnection.php';

// CONFERMA INDIRIZZO EMAIL E REGISTRAZIONE UTENTE
if (isset($_GET['codice'])) {

    $codice = $_GET['codice'];

    $query = "SELECT * FROM CacheTemporanea WHERE codiceCasuale = '%s'";
    $query = sprintf($query, $codice);

    $result = mysql_query($query);

    if (mysql_num_rows($result) > 0) {

        $informazioni = mysql_fetch_assoc($result);
        $nome = $informazioni['nome'];
        $cognome = $informazioni['cognome'];
        $dataNascita = $informazioni['dataNascita'];
        $codiceFiscale = $informazioni['codiceFiscale'];
        $email = $informazioni['email'];
        $password = $informazioni['password'];
        $via = $informazioni['via'];
        $citta = $informazioni['citta'];
        $regione = $informazioni['regione'];
        $provincia = $informazioni['provincia'];
        $cap = $informazioni['cap'];

        $queryUtente = "INSERT INTO Utente(CF, nome, cognome, password, "
                . "dataNascita, email, via, citta, provincia, regione, cap, tipoUtente) "
                . "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 0)";
        $queryUtente = sprintf($queryUtente, $codiceFiscale, $nome, $cognome, $password, 
                $dataNascita, $email, $via, $citta, $provincia, $regione, $cap);

        $resultUtente = mysql_query($queryUtente);

        if ($resultUtente) {

            $queryDelete = "DELETE FROM CacheTemporanea WHERE codiceCasuale = '%s'";
            $queryDelete = sprintf($queryDelete, $codice);

            $resultDelete = mysql_query($queryDelete);

            if ($resultDelete) {
                
                header("location: tmpPage.php?esito=0");
            } else {

                header("location: tmpPage.php?esito=1");
            }
        }
    }
}
?>

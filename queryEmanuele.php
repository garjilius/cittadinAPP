<?php

header("Content-Type: application/json; charset=UTF-8");
require_once './databaseconnection.php';

class Segnalazione {

    private $descrizione;
    private $dataOra;
    private $CF;
    private $luogo;
    private $lat;
    private $lng;
    private $livello;
    private $stato;

    function getDescrizione() {
        return $this->descrizione;
    }

    function getDataOra() {
        return $this->dataOra;
    }

    function getCF() {
        return $this->CF;
    }

    function getLuogo() {
        return $this->luogo;
    }

    function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    function setDataOra($dataOra) {
        $this->dataOra = $dataOra;
    }

    function setCF($CF) {
        $this->CF = $CF;
    }

    function setLuogo($luogo) {
        $this->luogo = $luogo;
    }

    function getLat() {
        return $this->lat;
    }

    function getLng() {
        return $this->lng;
    }

    function setLat($lat) {
        $this->lat = $lat;
    }

    function setLng($lng) {
        $this->lng = $lng;
    }
    
    function getLivello() {
        return $this->livello;
    }

    function setLivello($livello) {
        $this->livello = $livello;
    }

    function getStato() {
        return $this->stato;
    }

    function setStato($stato) {
        $this->stato = $stato;
    }
    
    function toJSON() {
        return array(
            "descrizione" => $this->descrizione,
            "dataOra" => $this->dataOra,
            "CF" => $this->CF,
            "luogo" => $this->luogo,
            "lat" => $this->lat,
            "lng" => $this->lng,
            "livello" => $this->livello,
            "stato" => $this->stato
        );
    }

}

// QUI DI SEGUITO LE QUERY NELLA SOLA TABELLA "SEGNALAZIONI"

function getArraySegnalazioni($result) {
    
    $numRighe = mysql_num_rows($result);
    $segnalazioni = array();

    for ($i = 0; $i < $numRighe; $i++) {

        $res = mysql_fetch_assoc($result);
        $tmp = new Segnalazione();
        $tmp->setDescrizione($res['descrizione']);
        $tmp->setDataOra($res['dataOra']);
        $tmp->setCF($res['CF']);
        $tmp->setLuogo($res['luogo']);
        $tmp->setLat($res['lat']);
        $tmp->setLng($res['lng']);
        $tmp->setLivello($res['livello']);
        $tmp->setStato($res['stato']);
        $segnalazioni[$i] = $tmp->toJSON();
    }
    
    return $segnalazioni;
}


// SCARICA SEGNALAZIONI ED INFORMAZIONI UTENTE
if (isset($_GET['cf'])) {

    $cf = $_GET['cf']."%";
    $informazioni = array();

    // ATTENDIBILITA UTENTE
    $query = "SELECT attendibilita FROM Utente WHERE CF LIKE '%s'";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[0] = $res[0];
    
    // VALUTAZIONE MEDIA SEGNALAZIONI 
    $query = "SELECT AVG(valutazione) FROM Segnalazione WHERE CF LIKE '%s' AND cfOperatore IS NOT NULL";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[1] = $res[0];
    
    // SEGNALAZIONI IN BASE AL LIVELLO
    $query = "SELECT COUNT(*) FROM Segnalazione WHERE CF LIKE '%s' AND livello = 0";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[2] = $res[0];
    
    $query = "SELECT COUNT(*) FROM Segnalazione WHERE CF LIKE '%s' AND livello = 1";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[3] = $res[0];

    $query = "SELECT COUNT(*) FROM Segnalazione WHERE CF LIKE '%s' AND livello = 2";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[4] = $res[0];
    
    $query = "SELECT COUNT(*) FROM Segnalazione WHERE CF LIKE '%s' AND livello = 3";
    $query = sprintf($query, $cf);
    $result = mysql_query($query);
    $res = mysql_fetch_row($result);
    $informazioni[5] = $res[0];
    
    echo json_encode($informazioni);
}

// SCARICA SEGNALAZIONI OPERATORE
if (isset($_GET['cfOperatore']) ) {

    $cfOperatore = $_GET['cfOperatore']."%";

    $query = "SELECT * FROM Segnalazione WHERE cfOperatore LIKE '%s'";
    $query = sprintf($query, $cfOperatore);
    $result = mysql_query($query);
    $segnalazioni = getArraySegnalazioni($result);

    //echo json_encode($segnalazioni);
    
    // MODIFICATO PER RESTITUIRE SOLO IL NUMERO DI SEGNALAZIONI
    echo count($segnalazioni);
}

// SCARICA SEGNALAZIONI LIVELLO
if (isset($_GET['livello'])) {

    $livello = $_GET['livello'];

    $query = "SELECT * FROM Segnalazione WHERE livello = '%s'";
    $query = sprintf($query, $livello);
    $result = mysql_query($query);
    $segnalazioni = getArraySegnalazioni($result);

    //echo json_encode($segnalazioni);
    
    // MODIFICATO PER RESTITUIRE SOLO IL NUMERO DI SEGNALAZIONI
    echo count($segnalazioni);
}

// SCARICA SEGNALAZIONI STATO
if (isset($_GET['stato'])) {

    $stato = $_GET['stato'];

    $query = "SELECT * FROM Segnalazione WHERE stato = '%s'";
    $query = sprintf($query, $stato);
    $result = mysql_query($query);
    $segnalazioni = getArraySegnalazioni($result);

    //echo json_encode($segnalazioni);
    //
    // MODIFICATO PER RESTITUIRE SOLO IL NUMERO DI SEGNALAZIONI
    echo count($segnalazioni);
}

// SCARICA SEGNALAZIONI DATA
if (isset($_GET['data'])) {

    $data = $_GET['data']."%";

    $query = "SELECT * FROM Segnalazione WHERE DATE(dataOra) LIKE '%s'";
    $query = sprintf($query, $data);
    $result = mysql_query($query);
    $segnalazioni = getArraySegnalazioni($result);

    //echo json_encode($segnalazioni);
    //
    // MODIFICATO PER RESTITUIRE SOLO IL NUMERO DI SEGNALAZIONI
    echo count($segnalazioni);
}

// QUI DI SEGUITO LE QUERY CHE UNISCONO LE TABELLE "SEGNALAZIONI" E "INDIRIZZO"

// SCARICA PROVINCIE DI UNA REGIONE
if (isset($_GET['allPro'])) {

    $regione = $_GET['allPro'];

    $query = "SELECT province.sigla FROM province JOIN Regione "
            . "ON province.id_regione = Regione.id AND Regione.nome = '%s'";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    
    $province = array();
    
    for($i=0; $i < mysql_num_rows($result); $i++) {
        
        $res = mysql_fetch_row($result);
        $province[$i] = $res[0];
        
    }
    
    echo json_encode($province);
}

// SCARICA SEGNALAZIONI IN CITTA
if (isset($_GET['citta']) && isset($_GET['allInfo'])) {

    $citta = $_GET['citta']."%"; //Percentuale aggiunta per il like... per prendere risultati man mano
    $info = array();

    // STATO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.stato = 0";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[0] = mysql_num_rows($result);
    
    // STATO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.stato = 1";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[1] = mysql_num_rows($result);
    
    // STATO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.stato = 2";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[2] = mysql_num_rows($result);
    
    // STATO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.stato = 3";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[3] = mysql_num_rows($result);
    
    // LIVELLO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.livello = 0";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[4] = mysql_num_rows($result);
    
    // LIVELLO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.livello = 1";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[5] = mysql_num_rows($result);
    
    // LIVELLO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.livello = 2";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[6] = mysql_num_rows($result);
    
    // LIVELLO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 LIKE '%s' AND Segnalazione.livello = 3";
    $query = sprintf($query, $citta);
    $result = mysql_query($query);
    $info[7] = mysql_num_rows($result);
 
    echo json_encode($info);
}



// SCARICA SEGNALAZIONI IN REGIONE PER OGNI STATO E LIVELLO
if (isset($_GET['regione']) && isset($_GET['allInfo'])) {

    $regione = $_GET['regione'];
    $info = array();

    // STATO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.stato = 0";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[0] = mysql_num_rows($result);
    
    // STATO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.stato = 1";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[1] = mysql_num_rows($result);
    
    // STATO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.stato = 2";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[2] = mysql_num_rows($result);
    
    // STATO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.stato = 3";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[3] = mysql_num_rows($result);
    
    // LIVELLO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.livello = 0";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[4] = mysql_num_rows($result);
    
    // LIVELLO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.livello = 1";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[5] = mysql_num_rows($result);
    
    // LIVELLO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.livello = 2";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[6] = mysql_num_rows($result);
    
    // LIVELLO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.regione = '%s' AND Segnalazione.livello = 3";
    $query = sprintf($query, $regione);
    $result = mysql_query($query);
    $info[7] = mysql_num_rows($result);
 
    echo json_encode($info);
}


// SCARICA SEGNALAZIONI IN PROVINCIA PER OGNI STATO E LIVELLO
if (isset($_GET['provincia']) && isset($_GET['allInfo'])) {

    $provincia = $_GET['provincia'];
    $info = array();

    // STATO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.stato = 0";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[0] = mysql_num_rows($result);
    
    // STATO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.stato = 1";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[1] = mysql_num_rows($result);
    
    // STATO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.stato = 2";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[2] = mysql_num_rows($result);
    
    // STATO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.stato = 3";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[3] = mysql_num_rows($result);
    
    // LIVELLO = 0
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.livello = 0";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[4] = mysql_num_rows($result);
    
    // LIVELLO = 1
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.livello = 1";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[5] = mysql_num_rows($result);
    
    // LIVELLO = 2
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.livello = 2";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[6] = mysql_num_rows($result);
    
    // LIVELLO = 3
    $query = "SELECT * FROM Segnalazione JOIN Indirizzo "
            . "ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' AND Segnalazione.livello = 3";
    $query = sprintf($query, $provincia);
    $result = mysql_query($query);
    $info[7] = mysql_num_rows($result);
 
    echo json_encode($info);
}


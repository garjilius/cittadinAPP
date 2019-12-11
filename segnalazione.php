<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Segnalazioni</title>
        <?php include './databaseconnection.php' ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="extra.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="starability/starability-minified/starability-all.min.css">

        <link href="apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <?php
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        ?>

    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="riepilogo.php">CittadinAPP</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="riepilogo.php">Elenco Segnalazioni</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
        $id = $_GET["id"];
        ?>

        <div class="container-fluid text-center">    
            <div class="container">
                <?php
                $query = "SELECT * FROM Segnalazione JOIN Indirizzo ON ID = idSegnalazione WHERE ID = " . $id . " ORDER BY id ASC";
                $risultato = mysql_query($query);
                $segnalazione = mysql_fetch_assoc($risultato);
                $query = "SELECT * FROM Utente WHERE CF = '" . $segnalazione["CF"] . "'";
                $risultato4 = mysql_query($query);
                $query = "SELECT COUNT(*) FROM Segnalazione WHERE id = '" . $id . "' AND cfOperatore IS NOT NULL";
                $risultato5 = mysql_query($query);
                $chiusa = mysql_fetch_row($risultato5);
                $userInfo = mysql_fetch_assoc($risultato4);

                //Assegno il giusto messaggio allo stato della segnalazione
                switch ($segnalazione["stato"]) {
                    case 0:
                        $messaggioSegnalazione = "Non Verificata";
                        break;
                    case 1:
                        $messaggioSegnalazione = "Riscontro positivo";
                        break;
                    case 2:
                        $messaggioSegnalazione = "Riscontro negativo";
                        break;
                    case 3:
                        $messaggioSegnalazione = "Verifica Richiesta";
                        break;
                }
                ?>

                <?php echo "<h2 id=titoloSegnalazione> Segnalazione $id</h2>" ?>
                <?php echo "<h3 id=statosegnalazione> $messaggioSegnalazione </h3>" ?> <BR>

                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" onclick="infoUtenteModal()">Informazioni Segnalatore</button>

                <H3>Descrizione</H3>
                <div class="well"><?php echo $segnalazione["descrizione"] ?></div><!-- Descrizione -->

                <h4><?php echo $segnalazione["via"] . ", " . $segnalazione["numeroCivico"] . ", " . $segnalazione["citta2"] . ", " . $segnalazione["provincia"] . ", " . $segnalazione["regione"] ?></h4> <!-- COMUNE -->


                <h5><?php
                    $area = str_replace("[", "", $segnalazione["area"]);
                    $area = str_replace("]", "", $area);

                    echo $segnalazione["coordinate"]
                    ?></h5> <!-- COORDINATE -->

                <h6>Data Segnalazione: <?php echo $segnalazione["dataOra"] ?></h6> <!-- DataEOra -->

            </div>


            <div class="modal fade" id="modaleUserInfo" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Informazioni Segnalatore</h4>
                        </div>
                        <div class="modal-body" id="bodyModaleUserInfo">
                            <h4>Nome </h4>
                            <h6 id="modalNome">PLACEHOLDER</h6>

                            <h4>Cognome </h4>
                            <h6 id="modalCognome">PLACEHOLDER</h6>

                            <h4>Data Di Nascita</h4>                        
                            <h6 id="modalNascita">PlaceHolder</h6>

                            <h4>CF</h4>
                            <h6 id="modalCF">PLACEHOLDER</h6>

                            <h4>Rating</h4>
                            <h6 id="modalRating">PLACEHOLDER%</h6>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="divImmagine">

                <div class="modal fade" id="imageModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Foto</h4>
                            </div>
                            <div class="modal-body" id="imageModalBody">
                            </div>            
                        </div>
                    </div>
                </div>
            </div>


            <div class ="space" style="height:30px;"></div>

            <!-- Responsive iFrame -->
            <div class="Flexible-container">
                <div id="googleMap" style="position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>
            </div>

            <script>

                var area = "<?php echo $area ?>";
                areaLatLong = area.split(",");
                for (i = 0; i < areaLatLong.length; i++) {
                    areaLatLong[i] = parseFloat(areaLatLong[i]);
                }


                function myMap() {

                    if (area != "") {


                        //SE E' SPECIFICATA Un'AREA, CARICA IL POLIGONO

                        var map = new google.maps.Map(document.getElementById('googleMap'), {
                            zoom: 17,
                            center: {lat: areaLatLong[0], lng: areaLatLong[1]},
                            mapTypeId: 'hybrid'
                        });

                        // Define the LatLng coordinates for the polygon's path.
                        var triangleCoords = []; //VUOTO, POI CI SPINGO LE COORDINATE DI OGNI PUNTO

                        for (i = 0; i < areaLatLong.length; i++) {
                            triangleCoords.push({lat: areaLatLong[i], lng: areaLatLong[++i]}); //i per le latitudini, ++i per le longitudini, visto che nella stringa lat-long sono alternate
                        }

                        // Construct the polygon.
                        var bermudaTriangle = new google.maps.Polygon({
                            paths: triangleCoords,
                            strokeColor: '#FF0000',
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: '#FF0000',
                            fillOpacity: 0.35
                        });
                        bermudaTriangle.setMap(map);

                    } else { //SE NON E' UN'AREA MA COORDINATE SEMPLICI
                        var coordinate = "<?php echo $segnalazione["coordinate"] ?>"; /* Prendo le coordinate dal PHP*/
                        var latitudine = parseFloat(coordinate.split(",")[0]); /* Le trasformo in numeri e le splitto*/
                        var longitudine = parseFloat(coordinate.split(",")[1]);
                        var coordinate = {lat: latitudine, lng: longitudine};
                        var mapProp = {
                            center: coordinate,
                            zoom: 18,
                            mapTypeId: google.maps.MapTypeId.HYBRID
                        };
                        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                        var marker = new google.maps.Marker({
                            position: coordinate,
                            map: map
                        });
                    }
                }

            </script>

            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi6OYQpSp_dEjtGzJ3hkeZXBw-wlMBUk0&callback=myMap"></script>


        </div>
    </div>

    <div class="container text-center bottoniRiscontro" id="bottoniRiscontro">    
        <div class ="space" style="height:30px;"></div>
        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="buttonClicked(this)" status="3" id="verifyButton">Viene riempito in javascript</button><BR>
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="buttonClicked(this)" status="1" id="positiveButton">Riscontro positivo</button><BR>
        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="buttonClicked(this)" status="2" id="negativeButton">Riscontro negativo</button><BR>
    </div>

    <div class="modal fade" id="rateModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Qualità Segnalazione</h4>
                </div>
                <div class="modal-body" id="rateModalBody">
                    <form>
                        <fieldset class="starability-slot"> 
                            <input type="radio" id="rate5" name="rating" value="20" onChange="handleStars(this)" />
                            <label for="rate5" title="Poco accurata">1 star</label>

                            <input type="radio" id="rate4" name="rating" value="40" onChange="handleStars(this)"/>
                            <label for="rate4" title="Discreta">2 stars</label>

                            <input type="radio" id="rate3" name="rating" value="60" onChange="handleStars(this)"/>
                            <label for="rate3" title="Media">3 stars</label>

                            <input type="radio" id="rate2" name="rating" value="80" onChange="handleStars(this)"/>
                            <label for="rate2" title="Molto buona">4 stars</label>

                            <input type="radio" id="rate1" name="rating" value="100" onChange="handleStars(this)"/>
                            <label for="rate1" title="Eccellente">5 star</label>
                        </fieldset>
                    </form>
                </div>            
            </div>
        </div>
    </div>


    <div class ="space" style="height:50px;"></div>    

    <div class="container legenda">
        <h5>LEGENDA</h5>
        <h6 class=bg-info>Blu: Livello non disponibile</h6>
        <h6 class=bg-success>Verde: Livello di attenzione</h6>
        <h6 class=bg-warning>Giallo: Livello di allarme</h6>
        <h6 class=bg-danger>Rosso: Livello di allerta</h6>
    </div>               

</body>

<script>

    //VERIFICA LOGIN
    function logout() {
        localStorage.removeItem("codiceFiscale");
        window.location = "https://cittadinapp.altervista.org/index.php";
    }

    $(document).ready(function () {
        if ((localStorage.getItem("tipoUtente") == 2)) {
            bottoni = document.getElementsByClassName("bottoniRiscontro")[0];
            bottoni.innerHTML = "";
        }
        if (!localStorage.codiceFiscale) {
            while (document.firstChild) {
                document.removeChild(document.firstChild);
            }
            window.location = "errorPage.php";
        } else {
            //console.log(sessionStorage.codiceFiscale);
        }
    });



    var images = <?php
                    if ($segnalazione['immagine'] == "") {
                        $segnalazione['immagine'] = 0;
                    }
                    echo $segnalazione['immagine']
                    ?>;
    console.log(images);

    if (images != 0) {
        for (i = 0; i < images.length; i++) {
            divImg = document.getElementById("divImmagine");
            divImg.innerHTML = divImg.innerHTML + "     <button type='button' data-toggle='modal' onclick='imgModal(" + i + ")' class='btn btn-primary btn-lg'>Foto " + (i + 1) + "</button>";
        }
    }

    bottoneVerifica = document.getElementById("verifyButton");
    segnalazioneChiusa = "<?php echo $chiusa[0] ?>";
    if (segnalazioneChiusa == 1) {
        disattivaBottoni();
    }


    function disattivaBottoni() {
        bottoni = document.getElementsByClassName("bottoniRiscontro")[0];
        bottoni.innerHTML = "<H2>SEGNALAZIONE CHIUSA</H2><BR><BR><BR><BR>";
    }

    function handleStars(star) {
        id = <?php echo $id ?>;
        var starValue = star.value;
        console.log("STARS: " + starValue);
        corpoModale = document.getElementById("rateModalBody");
        corpoModale.innerHTML = "<img height='40' width='40' src='true.png'>"
        setTimeout(function () {
            $('#rateModal').modal('hide');
            disattivaBottoni();
        }, 1000);
        query = "UPDATE `Segnalazione` SET valutazione =" + starValue + " WHERE `id` = " + id;
        ajaxConnect(query);
        aggiornaRating(id, status, cf);
        document.getElementById("statosegnalazione").innerText = "Riscontro positivo";

    }

    statoIniziale = "<?php echo $segnalazione["stato"] ?>";

    if (statoIniziale == 3) {
        bottoneVerifica.innerText = "Annulla Verifica";
        bottoneVerifica.setAttribute("status", 0);
        bottoneVerifica.className = "btn btn-info btn-lg btn-block";
    } else {
        bottoneVerifica.innerText = "Richiedi Verifica";
        bottoneVerifica.setAttribute("status", 3);
        bottoneVerifica.className = "btn btn-warning btn-lg btn-block";
    }


    function buttonClicked(clicked_object) {
        status = clicked_object.getAttribute('status');
        id = <?php echo $id ?>;
        cf = localStorage.codiceFiscale;
        if (status == 1) {
            $("#rateModal").modal("show");
            //sessionStorage.setItem("chiusa-" + id, true);
            //aggiornaRating(id, status, cf); // Disattivata perchè deve essere chiusa solo dopo la valutazione
        }
        if (status == 2) {
            document.getElementById("statosegnalazione").innerText = "Riscontro Negativo";
            //sessionStorage.setItem("chiusa-" + id, true);
            disattivaBottoni();
            aggiornaRating(id, status, cf);
        }
        if (status == 3) {
            document.getElementById("statosegnalazione").innerText = "Verifica Richiesta";
            query = "UPDATE `Segnalazione` SET stato =" + status + " WHERE `id` = " + id;
            ajaxConnect(query);

        }
        if (status == 0) {
            document.getElementById("statosegnalazione").innerText = "Non verificata";
            query = "UPDATE `Segnalazione` SET stato =" + status + " WHERE `id` = " + id;
            ajaxConnect(query);
        }

        if (status == 0 || status == 3) {
            handleVerifyButton(clicked_object);
        }
    }


//SEZIONE PER AGGIORNARE IL RATING! DA RIVEDERE!!!
    function aggiornaRating(id, stato, cfOperatore) {

        var cf = "<?php echo $userInfo["CF"] ?>";
        var xhr = new XMLHttpRequest();

        xhr.open("GET", "getRating.php?CF=" + cf + "&id=" + id + "&cfOperatore=" + cfOperatore + "&stato=" + stato + "&timestamp=" + Date.now(), true);
        xhr.send("");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                xmlDoc = xhr.responseXML.documentElement;
            }
        };
    }


    function imgModal(i) {

        zonaImmagine = document.getElementById("imageModalBody");
        rigaImmagine = '<img class="img-responsive" src="uploads/placeholder" alt="Immagine Segnalazione">';
        rigaImmagine = rigaImmagine.replace("placeholder", images[i]);
        zonaImmagine.innerHTML = rigaImmagine;

        $("#imageModal").modal("show");
    }


    function infoUtenteModal() {
        var cf = "<?php echo $userInfo["CF"] ?>";

        var xhr = new XMLHttpRequest();
        var modalNome = document.getElementById("modalNome");
        var modalCognome = document.getElementById("modalCognome");
        var modalNascita = document.getElementById("modalNascita");
        var modalCF = document.getElementById("modalCF");
        var modalRating = document.getElementById("modalRating");

        xhr.open("GET", "getUtenti.php?CF=" + cf + "&timestamp=" + Date.now(), true);
        xhr.send("");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                xmlDoc = xhr.responseXML.documentElement;
                nomePerModale = xmlDoc.getElementsByTagName("nome")[0].firstChild.nodeValue;
                cognomePerModale = xmlDoc.getElementsByTagName("cognome")[0].firstChild.nodeValue;
                dataNascitaPerModale = xmlDoc.getElementsByTagName("dataNascita")[0].firstChild.nodeValue;
                ratingPerModale = xmlDoc.getElementsByTagName("attendibilita")[0].firstChild.nodeValue;
                console.log("RATINGPERMODALE: " + ratingPerModale);
                modalNome.innerHTML = nomePerModale;
                modalCognome.innerHTML = cognomePerModale;
                modalCF.innerHTML = cf;
                modalNascita.innerHTML = dataNascitaPerModale;
                modalRating.innerHTML = ratingPerModale + "%";

                if (ratingPerModale == "-1") {
                    modalRating.innerHTML = "UTENTE IN PROVA";
                }

                $("#modaleUserInfo").modal("show");

            }
        };
    }

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
    function ajaxConnect(query) {
        xhr = new XMLHttpRequest();
        xhr.open("POST", "dbanswer1.php", true);
        xhr.send(query);
    }

// GESTIONE RICHIESTA VERIFICA
    function handleVerifyButton(clicked_object) {
        status = clicked_object.getAttribute('status');
        if (status == 3) {
            clicked_object.innerText = "Annulla Verifica";
            clicked_object.setAttribute("status", 0);
            clicked_object.className = "btn btn-info btn-lg btn-block";
        } else {
            clicked_object.innerText = "Richiedi Verifica";
            clicked_object.setAttribute("status", 3);
            clicked_object.className = "btn btn-warning btn-lg btn-block";
        }
    }




</script>
</html>


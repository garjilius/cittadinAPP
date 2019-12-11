<!DOCTYPE html>
<html lang="it">

    <head>

        <title>CittadinAPP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


        <link href="apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />

        <?php
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        ?>

    </head>
    <body>

        <!-- NAVIGATION BAR -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="formSegnalazioneUtente.php">CittadinAPP</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li role="button" ><a href="formSegnalazioneUtente.php">Nuova segnalazione</a></li>
                        <li role="button" ><a href="elencoSegnalazioniUtente.php">Le mie segnalazioni</a></li>
                        <li role="button" ><a href="inZonaUtente.php">Nella tua zona</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- MODALE DI ATTESA -->
        <div class="modal fade" id="modalLoading" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attendere...</h5>
                    </div>
                    <div class="modal-body">
                        <img class="img-responsive" style="display: block; margin-left: auto; margin-right: auto" src="caricamento.gif" alt="caricamento">
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        <div class="space" style="height: 30px" ></div>

        <div class="container">
            <form action="">

                <!-- TIPOLOGIA SEGNALAZIONE -->
                <div class="form-group">
                    <label for="tipoSegnalazione">Tipologia Segnalazione</label>
                    <select id="tipoSegnalazione" name="tipoSegnalazione" class="form-control" onchange="tipologiaSegnalazione()">
                        <option value="default">------------------</option>
                        <option value="allagamento">Allagamento locale interrati</option>
                        <option value="interruzione">Interruzione viabilit&agrave;</option>
                        <option value="danniOpere">Danni ad opere di contenimento, regimazione o attraversamento</option>
                        <option value="danniAttivita">Danni ad attivit&agrave; agricole</option>
                        <option value="perdite">Perdite umane o danni a persone</option>
                        <option value="distruzione">Distruzione edifici, opere di contenimento o altre costruzioni</option>
                        <option value="altro">Altro</option>
                    </select>
                </div>

                <!-- GEOLOCALIZZAZIONE -->
                <div class="form-group" id="divGeolocalizzazione" hidden="true"> 

                    <label>Indirizzo</label>

                    <button type="button" id="buttonGeo" onclick="geolocalizzami()" class="form-control btn btn-info">Geolocalizzami</button>

                    <div class="space" style="height: 15px" ></div>

                </div>

                <!-- INDIRIZZO E MAPPA -->
                <div class="form-group" id="divIndirizzo" hidden="true">

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-lg-6">
                            <input type="checkbox" id="checkboxArea" onclick="disegnaArea(this)"> Voglio disegnare un'area sulla mappa.
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6">
                            <button type="button" id="cancellaArea" class="btn btn-danger" style="position: absolute; right: 10px" disabled="true" onclick="deleteArea()">Cancella area</button>
                        </div>
                    </div>

                    <div class="space" style="height: 20px" ></div>

                    <div id="googleMap" style="width:100%;height:400px;"></div>

                    <div class="space" style="height: 15px" ></div>

                    <input type="text" id="indirizzo" class="form-control" disabled="true">

                    <div class="space" style="height: 15px" ></div>

                    <label>Controlla la presenza di errori nell'indirizzo rilevato.</label>
                    <div class="row" style="margin: auto">
                        <div class="col-xs-4 col-sm-4 col-lg-4">
                            <input type="checkbox" id="checkboxCivico" onclick="civicoErrato(this)"> Numero civico errato
                        </div>
                        <div class="col-xs-8 col-sm-8 col-lg-8">
                            <input type="number" id="civicoCorretto" disabled="true">
                        </div>
                    </div>

                    <div class="space" style="height: 10px" ></div>

                    <div class="row" style="margin: auto">
                        <div class="col-xs-4 col-sm-4 col-lg-4">
                            <input type="checkbox" id="checkboxVia" onclick="viaErrata(this)"> Via errata
                        </div>
                        <div class="col-xs-8 col-sm-8 col-lg-8">
                            <input type="text" id="viaCorretta" disabled="true">
                        </div>
                    </div>

                    <div class="space" style="height: 15px" ></div>

                    <button type="button" id="buttonIndirizzo" class="form-control btn btn-info" onclick="confermaIndirizzo()">Conferma indirizzo</button>

                </div>

                <!-- UPLOAD IMMAGINE -->
                <div class="form-group" id="divImmagine" hidden="true">

                    <label for="fileToUpload">Fotografia dell'accaduto</label>

                    <style>
                        .button-fotografia {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .button-fotografia i {
                            margin: 0 10px;
                        }
                    </style>

                    <label class="form-control btn btn-info button-fotografia">
                        Seleziona/scatta fotografia <i class="fas fa-camera fa-2x"></i><input type="file" id="fileToUpload" style="display: none;" onchange="uploadImage()">
                    </label>

                    <div class="space" style="height: 20px" ></div>

                </div>

                <!-- ANTEPRIMA IMMAGINE -->
                <div class="form-group" id="divAnteprimaImg" hidden="true">

                    <style>
                        .anteprimaImg {
                            width: 200px;
                            height: 200px;
                        }
                    </style>

                    <div id="rowAnteprimaImg" style="margin: auto">

                    </div> 

                    <div class="space" style="height: 20px" ></div>

                    <button type="button" id="buttonDeleteImg" class="form-control btn btn-danger" onclick="deleteImage()">Cancella foto</button>
                </div>

                <!-- ULTERIORI INFORMAZIONI -->
                <div class="form-group" id="divInformazioni" hidden="true">
                    <label for="descrizione">Descrizione del problema</label>
                    <textarea id="descrizione" name="descrizione" class="form-control" rows="4" cols="22" placeholder="Inserire una descrizione del problema"></textarea>
                </div>

                <!-- PULSANTI FINE FORUM -->
                <div class="form-group" id="fineForm" hidden="true">
                    <button type="button" id="buttonInvia" onclick="inviaSegnalazione()" class="form-control btn btn-success">INVIA SEGNALAZIONE</button>
                </div>

                <div class="space" style="height: 15px" ></div>
            </form>
        </div>

        <div class="space" style="height: 30px" ></div>

        <style>
            .info-how-to-area {
                background-color: #000000;
                width: 100%;
                min-height: 1000px;
                position: absolute;
                top: 0;
                z-index: 99999;
                opacity: 0.9;
                text-align: center;
                visibility: hidden;
            }

            .info-how-to-area p {

                margin-top: 25%;
                color: #ffffff;
                font-size: 15px;
            }
            
            @media (max-width: 991px) {
            
            	.info-how-to-area p {
                	margin-top: 100%!important;
            	}
            }
        </style>
        <div id="info-how-to-area" class="info-how-to-area">
            <p>
                Cliccare sull'icona <img src="images/iconaArea.png"> in alto sulla mappa.<br>
                Cliccare almeno due volte sulla mappa per visualizzare il primo lato del poligono.
            </p>
            <button class="btn btn-info" onclick="hideInfoArea()">Ho capito</button>
        </div>

        <script type="text/javascript">

            var map;
            var drawingManager;
            var poligono;
            function myMap() {
                var mapProp = {
                    center: new google.maps.LatLng(51.508742, -0.120850),
                    zoom: 5,
                };
                map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            }

        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQWW25Z2BamNwWy218hM8xHUtF4fU2pgo&libraries=drawing,places&callback=myMap"></script>

        <script type="text/javascript">

            // FUNZIONI INIZIALI
            $(document).ready(function () {
                if (localStorage.getItem("cittadinApp")) {

                } else {
                    alert("CONNESSIONE SCADUTA! Effettuare nuovamente il login!");
                    window.location = "index.php";
                }

            });

            // VARIABILI GLOBALI
            marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                draggable: true
            });

            google.maps.event.addListener(marker, "dragend", function (event) {

                markerSpostato();
            });

            var segnalazione = {
                cf: localStorage.getItem("cittadinApp"),
                coordinate: "",
                luogo: "",
                descrizione: "",
                livello: "",
                immagine: ""
            }

            var indirizzoObj = {
                lat: "",
                lng: "",
                streetNumber: "",
                route: "",
                locality: "",
                areaLevel1: "",
                areaLevel2: "",
                areaLevel3: "",
                country: "",
                postalCode: "",
                area: ""
            }

            // PASSO 1: TIPOLOGIA SEGNALAZIONE
            function tipologiaSegnalazione() {

                var tipoSegnalazione = document.getElementById("tipoSegnalazione").value;
                if (tipoSegnalazione == 'allagamento') {
                    segnalazione.livello = 1;
                    segnalazione.descrizione = "Allagamento locali interrati."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'interruzione') {
                    segnalazione.livello = 1;
                    segnalazione.descrizione = "Interruzione viabilità."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'danniOpere') {
                    segnalazione.livello = 2;
                    segnalazione.descrizione = "Danni alle opere di contenimento, regimazione o attraversamento."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'danniAttivita') {
                    segnalazione.livello = 2;
                    segnalazione.descrizione = "Danni ad attività agricole."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'perdite') {
                    segnalazione.livello = 3;
                    segnalazione.descrizione = "Perdite umane o danni a persone."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'distruzione') {
                    segnalazione.livello = 3;
                    segnalazione.descrizione = "Distruzione edifici o opere di contenimento, regimazione ed attraversamento."
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = true;
                } else if (tipoSegnalazione == 'altro') {
                    segnalazione.livello = 0;
                    document.getElementById("divGeolocalizzazione").hidden = false;
                    document.getElementById("divInformazioni").hidden = false;
                } else if (tipoSegnalazione == 'default') {

                    document.getElementById("divGeolocalizzazione").hidden = true;
                    document.getElementById("divIndirizzo").hidden = true;
                    document.getElementById("divInformazioni").hidden = true;
                    document.getElementById("divImmagine").hidden = true;
                }
            }

            // PASSO 2: INDIRIZZO E VISUALIZZAZIONE MAPPA

            // PASSO 2.1: GEOLOCALIZZAZIONE E VISUALIZZAZIONE MARKER SULLA MAPPA
            function geolocalizzami() {

                $('#modalLoading').modal('show');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                            mia_posizione,
                            gestisciErrore,
                            {
                                enableHighAccuracy: true,
                                maximumAge: 60000,
                                timeout: 10000
                            });
                } else {
                    alert("Il dispositivo non supporta la geolocalizzazione.");
                    return;
                }

                function mia_posizione(posizione) {

                    var lat = posizione.coords.latitude;
                    var lng = posizione.coords.longitude;

                    // SALVO COORDINATE RILEVATE
                    indirizzoObj.lat = lat;
                    indirizzoObj.lng = lng;

                    var apiKey = "&key=AIzaSyCQWW25Z2BamNwWy218hM8xHUtF4fU2pgo";
                    var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
                    var urlCompleto = url + lat + "," + lng + apiKey;
                    var httpReq = new XMLHttpRequest();
                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            $('#modalLoading').modal('hide');

                            var indirizzo = JSON.parse(httpReq.responseText);
                            document.getElementById("indirizzo").value = indirizzo.results[0].formatted_address;
                            smembraIndirizzo(indirizzo.results[0].address_components);

                            // Visualizzo sulla mappa
                            var myLatLng = new google.maps.LatLng(lat, lng);
                            map.setCenter(myLatLng);
                            map.setZoom(18);
                            marker.setPosition(myLatLng);
                            marker.setVisible(true);

                            document.getElementById("divIndirizzo").hidden = false;
                            $("html, body").animate({scrollTop: $("#googleMap").offset().top}, "slow");
                        }
                    };
                    httpReq.open("GET", urlCompleto, true);
                    httpReq.send();
                }
            }

            function smembraIndirizzo(address_components) {

                var numEl = address_components.length;

                for (i = 0; i < numEl; i++) {

                    var type = address_components[i].types[0];

                    if (type === "street_number") {

                        indirizzoObj.streetNumber = address_components[i].short_name;

                    } else if (type === "route") {

                        indirizzoObj.route = address_components[i].short_name;

                    } else if (type === "locality") {

                        indirizzoObj.locality = address_components[i].short_name;

                    } else if (type === "administrative_area_level_3") {

                        indirizzoObj.areaLevel3 = address_components[i].short_name;

                    } else if (type === "administrative_area_level_2") {

                        indirizzoObj.areaLevel2 = address_components[i].short_name;

                    } else if (type === "administrative_area_level_1") {

                        indirizzoObj.areaLevel1 = address_components[i].short_name;

                    } else if (type === "country") {

                        indirizzoObj.country = address_components[i].short_name;

                    } else if (type === "postal_code") {

                        indirizzoObj.postalCode = address_components[i].short_name;

                    }
                }
            }

            function gestisciErrore(error) {

                $('#modalLoading').modal('hide');

                switch (error.code) {

                    case error.PERMISSION_DENIED:
                        alert("Permesso negato dall'utente.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Impossibile rilevare la posizione.");
                        break;
                    case error.TIMEOUT:
                        alert("Timeout scaduto.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("Errore sconosciuto.");
                        break;
                }
            }

            // PASSO 2.2: L'UTENTE SPOSTA IL MARKER
            function markerSpostato() {

                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                var apiKey = "&key=AIzaSyCQWW25Z2BamNwWy218hM8xHUtF4fU2pgo";
                var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
                var urlCompleto = url + lat + "," + lng + apiKey;

                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        var indirizzo = JSON.parse(httpReq.responseText);
                        document.getElementById("indirizzo").value = indirizzo.results[0].formatted_address;

                        // SALVO LE NUOVE INFORMAZIONI
                        smembraIndirizzo(indirizzo.results[0].address_components);
                        indirizzoObj.lat = lat;
                        indirizzoObj.lng = lng;
                    }
                };
                httpReq.open("GET", urlCompleto, true);
                httpReq.send();
            }

            // PASSO 2.3: L'UTENTE RILEVA UN ERRORE NELL'INDIRIZZO
            function civicoErrato(input) {

                if (input.checked) {

                    document.getElementById("civicoCorretto").disabled = false;
                    document.getElementById("civicoCorretto").focus();
                } else {

                    document.getElementById("civicoCorretto").disabled = true;
                }
            }

            function viaErrata(input) {

                if (input.checked) {

                    document.getElementById("viaCorretta").disabled = false;
                    document.getElementById("viaCorretta").focus();
                } else {

                    document.getElementById("viaCorretta").disabled = true;
                }
            }

            // PASSO 2.4: L'UTENTE VUOLE DISEGNARE UN'AREA SULLA MAPPA
            function disegnaArea(input) {

                if (input.checked) {

                    document.getElementById("info-how-to-area").style.visibility = 'visible';

                    document.getElementById("cancellaArea").disabled = false;
                    if (drawingManager == null) {
                        drawingManager = new google.maps.drawing.DrawingManager({
                            drawingControl: true,
                            drawingControlOptions: {
                                position: google.maps.ControlPosition.TOP_CENTER,
                                drawingModes: ['polygon']
                            }
                        });
                        drawingManager.setMap(map);
                        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {

                            poligono = polygon;
                            var vertices = polygon.getPath();
                            var toJson = [];
                            for (var i = 0; i < vertices.getLength(); i++) {
                                var xy = vertices.getAt(i);
                                var latLng = []
                                latLng[0] = xy.lat();
                                latLng[1] = xy.lng();
                                toJson[i] = latLng;
                            }

                            indirizzoObj.area = JSON.stringify(toJson);
                        });
                    } else {

                        drawingManager.setMap(map);
                    }

                } else {

                    drawingManager.setMap(null);
                    document.getElementById("cancellaArea").disabled = true;
                    indirizzoObj.area = "";
                    if (poligono != null)
                        poligono.setVisible(false);
                }
            }

            function deleteArea() {

                if (poligono != null)
                    poligono.setVisible(false);
            }

            function hideInfoArea() {

                document.getElementById("info-how-to-area").style.visibility = 'hidden';
            }

            function confermaIndirizzo() {

                // CONTROLLO SE L'UTENTE HA APPORTATO CORREZZIONI
                var checkboxCivico = document.getElementById("checkboxCivico");
                var checkboxVia = document.getElementById("checkboxVia");

                // L'UTENTE HA CORRETTO IL NUMERO CIVICO
                if (checkboxCivico.checked) {

                    var civicoCorretto = document.getElementById("civicoCorretto").value;

                    if (civicoCorretto.length == 0) {

                        alert("Inserire un civico oppure spuntare la checkbox.");
                        return;
                    } else {

                        indirizzoObj.streetNumber = civicoCorretto;
                    }
                }

                // L'UTENTE HA CORRETTO LA VIA
                if (checkboxVia.checked) {

                    var viaCorretta = document.getElementById("viaCorretta").value;

                    if (viaCorretta.length == 0) {

                        alert("Inserire una via corretta oppure spuntare la checkbox");
                        return;
                    } else {

                        indirizzoObj.route = viaCorretta;
                    }

                }

                // CONTROLLO SE L'UTENTE HA INSERITO UN'AREA
                var checkboxArea = document.getElementById("checkboxArea");

                if (!checkboxArea.checked) {

                    segnalazione.coordinate = indirizzoObj.lat + ", " + indirizzoObj.lng;

                    segnalazione.luogo = indirizzoObj.route + ", " + indirizzoObj.streetNumber + ", "
                            + indirizzoObj.postalCode + " " + indirizzoObj.locality + " "
                            + indirizzoObj.areaLevel2 + ", " + indirizzoObj.country;

                } else if (indirizzoObj.area.length == 0) {

                    alert("Disegnare un'area sulla mappa.");
                    return;

                }

                // DISABILITO CHECKBOX
                document.getElementById("checkboxArea").disabled = true;
                document.getElementById("checkboxVia").disabled = true;
                document.getElementById("checkboxCivico").disabled = true;

                // DISABILITO INPUT TEXT
                document.getElementById("viaCorretta").disabled = true;
                document.getElementById("civicoCorretto").disabled = true;

                // DISABILITO SELECT TIPO E PULSANTI
                document.getElementById("tipoSegnalazione").disabled = true;
                document.getElementById("buttonGeo").disabled = true;
                document.getElementById("buttonIndirizzo").disabled = true;
                document.getElementById("divImmagine").hidden = false;
                document.getElementById("fineForm").hidden = false;

                $("html, body").animate({scrollTop: $("#divImmagine").offset().top}, "slow");
            }

            // PASSO 3: UPLOAD FOTO
            var uploadedFiles = [];

            function uploadImage() {

                var fileSelect = document.getElementById('fileToUpload');

                var files = fileSelect.files;

                if (files.length == 0)
                    return;

                var formData = new FormData();
                var file = files[0];

                if (!file.type.match('image.*')) {

                    alert("Il file inserito non è una immagine.");
                    return;
                } else if (file.size > 7340032) {

                    alert("Dimensione immagine MAX 7MB.");
                    return;
                }

                var index = uploadedFiles.length;
                uploadedFiles[index] = file.name.replace(/ /g, '');
                formData.append('fileToUpload', file, uploadedFiles[index]);

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {

                    if (xhr.readyState == 4 && xhr.status == 200) {

                        $('#modalLoading').modal('hide');
                        var response = parseInt(xhr.responseText);
                        switch (response) {
                            case 0:
                                fileSelect.value = "";
                                visualizzaAnteprimaImg();
                                break;
                        }
                    }
                }

                xhr.open('POST', 'uploadFile.php', true);
                $('#modalLoading').modal('show');
                xhr.send(formData);
            }

            function visualizzaAnteprimaImg() {

                if (!(document.getElementById("checkboxArea").checked)) {
                    document.getElementById("fileToUpload").disabled = true;
                }

                // CREO L'ANTEPRIMA
                var img = document.createElement("img");
                img.setAttribute("class", "form-control img-thumbnail anteprimaImg");

                var index = uploadedFiles.length - 1;
                img.setAttribute("alt", uploadedFiles[index]);
                img.setAttribute("src", "uploads/" + uploadedFiles[index]);

                // AGGIUNGO L'ANTEPRIMA
                var row = document.getElementById("rowAnteprimaImg");
                row.appendChild(img);

                document.getElementById("divAnteprimaImg").hidden = false;
                segnalazione.immagine = JSON.stringify(uploadedFiles);

                $("html, body").animate({scrollTop: $("#divAnteprimaImg").offset().top}, "slow");
            }

            function deleteImage() {

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {

                    if (xhr.readyState == 4 && xhr.status == 200) {

                        var response = parseInt(xhr.responseText);
                        switch (response) {
                            case 0:
                                uploadedFiles.pop();
                                segnalazione.immagine = JSON.stringify(uploadedFiles);
                                document.getElementById("divAnteprimaImg").hidden = true;
                                
                                var row = document.getElementById("rowAnteprimaImg");
                                row.removeChild(row.lastChild);
                                
                                document.getElementById("fileToUpload").disabled = false;
                                break;
                        }
                    }
                }

                var index = uploadedFiles.length - 1;
                var url = "deleteFile.php?fileName=" + uploadedFiles[index];
                xhr.open('GET', url, true);
                xhr.send();
            }

            // PASSO FINALE: INVIO SEGNALAZIONE
            function inviaSegnalazione() {

                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        var x = parseInt(httpReq.responseText);
                        if(x == 1) {
                            location.href = "elencoSegnalazioniUtente.php";
                        } else {
                            alert("PROBLEMA RILEVATO! Contattare l'assistenza.");
                        }
                    }
                };

                var descrizione = document.getElementById("descrizione").value;
                if (segnalazione.livello == 0 && descrizione.length == 0) {

                    alert("Inserire una descrizione del problema.")
                    return;
                } else if (segnalazione.livello == 0) {

                    segnalazione.descrizione = descrizione;
                }
                
                var jsonS = JSON.stringify(segnalazione);
                var jsonI = JSON.stringify(indirizzoObj);

                httpReq.open("POST", "operazioniUtente.php", true);
                httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpReq.send("jsonS=" + jsonS + "&jsonI=" + jsonI);

                //logSegnalazione();
            }

            function logSegnalazione() {

                console.log(segnalazione);
                console.log(indirizzoObj);
            }

        </script>
    </body>

</html>







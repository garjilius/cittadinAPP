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

    <body onload="rilevaPosizione()">

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

            <!-- INDIRIZZO E GEOLOCALIZZAZIONE -->
            <div class="form-group"> 
                <label for="indirizzo">Inserire un indirizzo per ricerca manuale</label>
                <input type="text" id="indirizzo" class="form-control">

            </div>

            <div class="space" style="height: 15px" ></div>

            <button data-toggle="collapse" data-target="#demo" class="btn btn-info">Legenda</button>

            <div class="space" style="height: 15px" ></div>

            <div id="demo" class="collapse">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png"></td>
                                <td>La tua posizione</td>
                            </tr>
                            <tr>
                                <td><img src="iconeMappa/azzurro.png"></td>
                                <td>Livello non disponibile</td>
                            </tr>
                            <tr>
                                <td><img src="iconeMappa/verde.png"></td>
                                <td>Livello di attenzione</td>
                            </tr>
                            <tr>
                                <td><img src="iconeMappa/giallo.png"></td>
                                <td>Livello di allerta</td>
                            </tr>
                            <tr>
                                <td><img src="iconeMappa/rosso.png"></td>
                                <td>Livello di allarme</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="space" style="height: 30px" ></div>

        <div class="container">

            <!-- MAPPA -->
            <div class="form-group">
                <div id="googleMap" style="width:100%;height:400px;"></div>
            </div>

        </div>

        <script type="text/javascript">

            var map;

            function myMap() {
                var mapProp = {
                    center: new google.maps.LatLng(51.508742, -0.120850),
                    zoom: 5,
                };
                map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            }

        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQWW25Z2BamNwWy218hM8xHUtF4fU2pgo&libraries=places&callback=myMap"></script>


        <script type="text/javascript">

            // FUNZIONI INIZIALI
            $(document).ready(function () {
                if (localStorage.getItem("cittadinApp")) {
                    console.log("Utente connesso: " + localStorage.cittadinApp);
                } else {
                    alert("CONNESSIONE SCADUTA! Effettuare nuovamente il login!");
                    window.location = "index.php";
                }

            });

            var autocomplete;

            var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
            var userPosition = new google.maps.Marker({
                map: map,
                icon: image
            });

            function init() {

                var input = document.getElementById('indirizzo');
                autocomplete = new google.maps.places.Autocomplete(input);

                autocomplete.addListener('place_changed', function () {

                    $('#modalLoading').modal('show');

                    userPosition.setVisible(false);

                    var place = autocomplete.getPlace();
                    if (!place.geometry) {

                        window.alert("No details available for input: '" + place.name + "'");
                        return;

                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(13);
                    }
                    userPosition.setPosition(place.geometry.location);
                    userPosition.setVisible(true);

                    smembraIndirizzo(place.address_components);

                });
            }
            google.maps.event.addDomListener(window, 'load', init);


            // FUNZIONI GEOLOCALIZZAZIONE
            function rilevaPosizione() {

                $('#modalLoading').modal('show');

                //QUESTA PARTE DI CODICE RILEVA LA POSIZIONE DEL DISPOSITIVO
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
                    document.getElementById("alertErrore").innerHTML = "Il dispositivo non supporta la <strong>geolocalizzazione</strong>.";
                    document.getElementById("alertErrore").hidden = false;
                    return;
                }

                function mia_posizione(posizione) {

                    var lat = posizione.coords.latitude;
                    var lng = posizione.coords.longitude;
                    var apiKey = "&key=AIzaSyCQWW25Z2BamNwWy218hM8xHUtF4fU2pgo";
                    var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
                    var urlCompleto = url + lat + "," + lng + apiKey;
                    var httpReq = new XMLHttpRequest();
                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var myLatLng = new google.maps.LatLng(lat, lng);
                            map.setCenter(myLatLng);
                            map.setZoom(13);
                            userPosition.setPosition(myLatLng);

                            var indirizzo = JSON.parse(httpReq.responseText);
                            document.getElementById("indirizzo").value = indirizzo.results[0].formatted_address;
                            smembraIndirizzo(indirizzo.results[0].address_components);
                        }
                    };
                    httpReq.open("GET", urlCompleto, true);
                    httpReq.send();
                }
            }

            function gestisciErrore(error) {

                $('#modalLoading').modal('hide');
                switch (error.code) {

                    case error.PERMISSION_DENIED:
                        document.getElementById("alertErrore").innerHTML = "<strong>Permesso negato</strong> dall'utente.";
                        document.getElementById("alertErrore").hidden = false;
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById("alertErrore").innerHTML = "Impossibile rilevare la <strong>posizione</strong>.";
                        document.getElementById("alertErrore").hidden = false;
                        break;
                    case error.TIMEOUT:
                        document.getElementById("alertErrore").innerHTML = "<strong>Timeout scaduto</strong>.";
                        document.getElementById("alertErrore").hidden = false;
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById("alertErrore").innerHTML = "<strong>Errore sconosciuto</strong>.";
                        document.getElementById("alertErrore").hidden = false;
                        break;
                }
            }

            // FUNZIONI PER LA VISUALIZZAZIONE DELLE SEGNALAZIONI
            var provincia = "";
            var citta = "";

            function smembraIndirizzo(address_components) {

                var numEl = address_components.length;

                for (i = 0; i < numEl; i++) {

                    var type = address_components[i].types[0];

                    if (type === "administrative_area_level_3") {

                        citta = address_components[i].short_name;

                    } else if (type === "administrative_area_level_2") {

                        provincia = address_components[i].short_name;

                    }
                }
                
                segnalazioniCitta();
                segnalazioniProvincia();
                $('#modalLoading').modal('hide');
            }

            function segnalazioniProvincia() {

                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        if (httpReq.responseText != 'false') {

                            var segnalazioni = JSON.parse(httpReq.responseText);

                            console.log("# PROVINCIA: " + segnalazioni.length);

                            for (i = 0; i < segnalazioni.length; i++) {

                                var latS = segnalazioni[i].lat;
                                var lngS = segnalazioni[i].lng;

                                var latLngS = new google.maps.LatLng(latS, lngS);

                                var icona = "iconeMappa/";
                                switch (segnalazioni[i].livello) {
                                    case "0":
                                        icona += "azzurro.png";
                                        break;
                                    case "1":
                                        icona += "verde.png";
                                        break;
                                    case "2":
                                        icona += "giallo.png";
                                        break;
                                    case "3":
                                        icona += "rosso.png";
                                        break;
                                }

                                var marker = new google.maps.Marker({
                                    position: latLngS,
                                    icon: icona
                                });

                                marker['infowindow'] = new google.maps.InfoWindow({
                                    content: segnalazioni[i].descrizione
                                });

                                google.maps.event.addListener(marker, 'click', function () {
                                    this['infowindow'].open(map, this);
                                });

                                marker.setMap(map);
                            }
                        }

                    }
                };
                var url = "operazioniUtente.php?provincia=" + provincia;
                httpReq.open("GET", url, true);
                httpReq.send();
            }

            function segnalazioniCitta() {

                var httpReq = new XMLHttpRequest();

                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {


                        if (httpReq.responseText != 'false') {

                            var segnalazioni = JSON.parse(httpReq.responseText);

                            console.log("# CITTA: " + segnalazioni.length);

                            for (i = 0; i < segnalazioni.length; i++) {

                                var latS = segnalazioni[i].lat;
                                var lngS = segnalazioni[i].lng;

                                var latLngS = new google.maps.LatLng(latS, lngS);

                                var icona = "iconeMappa/";
                                switch (segnalazioni[i].livello) {
                                    case "0":
                                        icona += "azzurro.png";
                                        break;
                                    case "1":
                                        icona += "verde.png";
                                        break;
                                    case "2":
                                        icona += "giallo.png";
                                        break;
                                    case "3":
                                        icona += "rosso.png";
                                        break;
                                }

                                var marker = new google.maps.Marker({
                                    position: latLngS,
                                    icon: icona
                                });

                                marker['infowindow'] = new google.maps.InfoWindow({
                                    content: segnalazioni[i].descrizione,
                                    maxWidth: 100
                                });

                                google.maps.event.addListener(marker, 'click', function () {
                                    this['infowindow'].open(map, this);
                                });

                                marker.setMap(map);

                            }
                        }
                    }
                };

                var url = "operazioniUtente.php?citta=" + citta;
                httpReq.open("GET", url, true);
                httpReq.send();

            }

        </script>
    </body>

</html>







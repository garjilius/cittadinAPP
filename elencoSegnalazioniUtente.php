<!DOCTYPE html>
<html lang="en">

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

    <body onload="elencoSegnalazioni()">

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

        <div class="container">

            <button data-toggle="collapse" data-target="#demo" class="btn btn-info">Legenda</button>

            <div class="space" style="height: 15px" ></div>

            <!-- LEGENDA -->
            <div id="demo" class="collapse">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="table-responsive">
                            <h5 style="text-align: center">LEGENDA COLORI</h5>
                            <table class="table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr class="success">
                                        <td>Verde - livello di attenzione</td>
                                    </tr>
                                    <tr class="danger">
                                        <td>Rosso - livello di allarme</td>
                                    </tr>
                                    <tr class="info">
                                        <td>Blu - livello non disponibile</td>
                                    </tr>
                                    <tr class="warning">
                                        <td>Giallo - livello di allerta</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="table-responsive">
                            <h5 style="text-align: center">LEGENDA SIMBOLI</h5>
                            <table class="table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img width="30" height="30" src="unverified.png"</td>
                                        <td>Nessuna operazione richiesta</td>
                                    </tr>
                                    <tr>
                                        <td><img width="30" height="30" src="true.png"</td>
                                        <td>Riscontro positivo</td>
                                    </tr>
                                    <tr>
                                        <td><img width="30" height="30" src="false.png"</td>
                                        <td>Riscontro negativo</td>
                                    </tr>
                                    <tr>
                                        <td><img width="30" height="30" src="waiting.png"</td>
                                        <td>In attesa di riscontro</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <h3 id="intestazioneTabella">
                <script type="text/javascript">
                    var intestazione = "Riepilogo segnalazioni: " + localStorage.getItem("cittadinApp");
                    document.getElementById("intestazioneTabella").appendChild(document.createTextNode(intestazione));
                </script>
            </h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Stato</th>
                            <th>Data - Ora - Luogo</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTabella">

                    <style>
                        tr:hover {
                            cursor: pointer;
                        }
                    </style>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="space" style="height: 30px" ></div>

        <!-- MODALE INFORMAZIONI -->
        <div class="modal fade" id="modalInfo" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Informazioni segnalazione</h5>
                    </div>
                    <div class="modal-body">
                        <form action="">

                            <div class="form-group">
                                <label>Descrizione</label>
                                <textarea id="descrizione" class="form-control" rows="3" cols="15"></textarea>
                            </div>

                            <style>
                                .anteprimaImg {
                                    width: 200px;
                                    height: 200px;
                                }
                            </style>

                            <div class="form-group" id="modalImmagini" hidden="true">

                            </div>

                            <div class="form-group" id="modalArea" hidden="true">
                                <label>Area della segnalazione</label>
                                <div id="googleMap" style="width:100%;height:200px;"></div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .info-click-table {
                background-color: red;
                color: white;
                width: auto;
                height: auto;
                position: fixed;
                right: 250px;
                top: 25%;
                padding: 0 10px;
            }

            @media (max-width: 991px) {

                .info-click-table {
                    right: 0!important;
                    bottom: 5px!important;
                    top: unset!important;
                }
            }
        </style>
        <div class="info-click-table">
            <p>Cliccare sulla riga per tutti i dettagli della segnalazione</p>
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

            $(document).ready(function () {
                if (localStorage.getItem("cittadinApp")) {
                    console.log(localStorage.cittadinApp);
                } else {
                    alert("CONNESSIONE SCADUTA! Effettuare nuovamente il login!");
                    window.location = "index.php";
                }

            });

            var segnalazioni;

            function elencoSegnalazioni() {

                var httpReq = new XMLHttpRequest();

                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        if (httpReq.responseText != 'false') {

                            segnalazioni = JSON.parse(httpReq.responseText);
                            var tabellaCitta = document.getElementById("bodyTabella");

                            for (i = 0; i < segnalazioni.length; i++) {

                                // ICONA STATO SEGNALAZIONE
                                var stato = document.createElement("td");
                                var immagine = document.createElement("img");
                                immagine.setAttribute("height", "40");
                                immagine.setAttribute("width", "40");
                                switch (segnalazioni[i].stato) {
                                    case "0":
                                        immagine.setAttribute("src", "unverified.png");
                                        break;
                                    case "1":
                                        immagine.setAttribute("src", "true.png");
                                        break;
                                    case "2":
                                        immagine.setAttribute("src", "false.png");
                                        break;
                                    case "3":
                                        immagine.setAttribute("src", "waiting.png");
                                        break;
                                }
                                stato.appendChild(immagine);

                                // DATA ORA LUOGO
                                var dataOraLuogo = document.createElement("td");
                                var stringa = segnalazioni[i].dataOra + " - ";

                                if (segnalazioni[i].luogo.length != 0)
                                    stringa += segnalazioni[i].luogo;
                                else
                                    stringa += "Segnalazione con AREA DISEGNATA";
                                dataOraLuogo.appendChild(document.createTextNode(stringa));

                                // CREO LA RIGA ED AGGIUNGO LE COLONNE
                                var riga = document.createElement("tr");
                                riga.setAttribute("value", i);

                                switch (segnalazioni[i].livello) {
                                    case "0":
                                        riga.setAttribute("class", "info table-row");
                                        break;
                                    case "1":
                                        riga.setAttribute("class", "success table-row");
                                        break;
                                    case "2":
                                        riga.setAttribute("class", "warning table-row");
                                        break;
                                    case "3":
                                        riga.setAttribute("class", "danger table-row");
                                        break;
                                }

                                riga.appendChild(stato);
                                riga.appendChild(dataOraLuogo);

                                riga.onclick = infoSegnalazione;

                                // AGGIUNGO LA RIGA ALLA TABELLA
                                tabellaCitta.appendChild(riga);

                            }

                        }
                    }
                };

                var url = "operazioniUtente.php?cf=" + localStorage.getItem("cittadinApp") + "&elenco=yes";
                httpReq.open("GET", url, true);
                httpReq.send();

            }

            var poligono = null;

            function infoSegnalazione() {

                id = this.getAttribute("value");

                // VISUALIZZO DESCRIZIONE
                var textArea = document.getElementById("descrizione");
                textArea.value = segnalazioni[id].descrizione;

                // VISUALIZZO IMMAGINI SE CI SONO
                var modalImmagini = document.getElementById("modalImmagini");

                if (segnalazioni[id].immagine.length != 0) {

                    var immagini = JSON.parse(segnalazioni[id].immagine);

                    while (modalImmagini.hasChildNodes()) {
                        modalImmagini.removeChild(modalImmagini.firstChild);
                    }

                    var label = document.createElement("label");
                    label.innerHTML = "Immagini";
                    modalImmagini.appendChild(label);

                    for (i = 0; i < immagini.length; i++) {

                        var img = document.createElement("img");
                        var src = "uploads/" + immagini[i];
                        img.setAttribute("src", src);
                        img.setAttribute("class", "form-control anteprimaImg img-thumbnail");

                        modalImmagini.appendChild(img);
                    }

                    modalImmagini.hidden = false;

                } else {

                    modalImmagini.hidden = true;
                }

                // VISUALIZZO AREA SULLA MAPPA
                var modalArea = document.getElementById("modalArea");

                if (segnalazioni[id].luogo.length == 0) {
                    
                    if(poligono != null) {
                        
                        poligono.setMap(null);
                    }

                    modalArea.hidden = false;

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var coordinate = JSON.parse(httpReq.responseText);

                            var verticiPoligono = [];

                            for (i = 0; i < coordinate.length; i++) {

                                var lat = coordinate[i][0];
                                var lng = coordinate[i][1];
                                var latLng = new google.maps.LatLng(lat, lng);
                                verticiPoligono[i] = latLng.toJSON();

                            }

                            map.setCenter(verticiPoligono[0]);
                            map.setZoom(16);

                            poligono = new google.maps.Polygon({
                                paths: verticiPoligono,
                                strokeColor: '#FF0000',
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: '#FF0000',
                                fillOpacity: 0.35
                            });
                            poligono.setMap(map);

                        }
                    };

                    var url = "operazioniUtente.php?idSegnalazione=" + segnalazioni[id].id + "&area=yes";
                    httpReq.open("GET", url, true);
                    httpReq.send();

                } else {

                    modalArea.hidden = true;
                }


                $('#modalInfo').modal('show');
            }

        </script>

    </body>
</html>

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
                    <ul class="nav navbar-nav bottoniStato">
                        <li role="button" class ="bottoneStato" daMostrare = "tutte" onclick=show(this)><a href="riepilogo.php">Elenco Segnalazioni</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="space" style="height: 20px" ></div>

        <div class="container">

            <H2>Statistiche Segnalazioni</H2><BR><BR>

            <!-- SELEZIONARE UNA REGIONE -->            
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color ="green"><label for="provincia">Statistiche per regione</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-6">
                    <select id="regione" onchange="segnalazioniRegione(this)">
                        <?php
                        require_once './databaseconnection.php';

                        $query = "SELECT nome FROM Regione";
                        $result = mysql_query($query);
                        $numRighe = mysql_num_rows($result);

                        echo '<option value="default">--------------------</option>';
                        for ($i = 0; $i < $numRighe; $i++) {
                            $regioni = mysql_fetch_row($result);
                            $tmp = $regioni[0];
                            echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color="blue"><label># segnalazioni</label></font>
                    <input type="text" id="numRegione" disabled="true">
                </div>
            </div>

            <!-- TABELLA INFO REGIONE -->
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nessuna operazione</th>
                            <th>Riscontro positivo</th>
                            <th>Riscontro negativo</th>
                            <th>In attesa di verifica</th>
                            <th>Livello normale</th>
                            <th>Livello di attenzione</th>
                            <th>Livello di allerta</th>
                            <th>Livello di allarme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="numRegStato0"></td>
                            <td id="numRegStato1"></td>
                            <td id="numRegStato2"></td>
                            <td id="numRegStato3"> </td>
                            <td id="numRegLivello0"></td>
                            <td id="numRegLivello1"></td>
                            <td id="numRegLivello2"></td>
                            <td id="numRegLivello3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="space" style="height: 30px" ></div>

            <hr>

            <!-- SELEZIONARE UNA PROVINCIA -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color="green"><label for="provincia">Statistiche per provincia</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-6">
                    <select id="provincia" onchange="segnalazioniProvincia(this)" disabled="true">

                    </select>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color="blue"> <label># segnalazioni</label></font>
                    <input type="text" id="numProvincia" disabled="true">
                </div>
            </div>

            <!-- TABELLA INFO PROVINCIA -->
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nessuna operazione</th>
                            <th>Riscontro positivo</th>
                            <th>Riscontro negativo</th>
                            <th>In attesa di verifica</th>
                            <th>Livello normale</th>
                            <th>Livello di attenzione</th>
                            <th>Livello di allerta</th>
                            <th>Livello di allarme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="numProStato0"></td>
                            <td id="numProStato1"></td>
                            <td id="numProStato2"></td>
                            <td id="numProStato3"> </td>
                            <td id="numProLivello0"></td>
                            <td id="numProLivello1"></td>
                            <td id="numProLivello2"></td>
                            <td id="numProLivello3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="space" style="height: 30px" ></div>

            <hr>

            <!-- SEGNALAZIONI CITTA -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color="green"><label for="citta">Statistiche per citt&agrave;</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-6">
                    <input type="text" id="citta" oninput="segnalazioniCitta()" placeholder="Citt&agrave;">
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color = "blue"><label># segnalazioni</label></font>
                    <input type="text" id="numCitta" disabled="true">
                </div>
            </div>

            <!-- TABELLA INFO CITTA -->
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nessuna operazione</th>
                            <th>Riscontro positivo</th>
                            <th>Riscontro negativo</th>
                            <th>In attesa di verifica</th>
                            <th>Livello normale</th>
                            <th>Livello di attenzione</th>
                            <th>Livello di allerta</th>
                            <th>Livello di allarme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="rowCitta">
                            <td id="numCittaStato0"></td>
                            <td id="numCittaStato1"></td>
                            <td id="numCittaStato2"></td>
                            <td id="numCittaStato3"> </td>
                            <td id="numCittaLivello0"></td>
                            <td id="numCittaLivello1"></td>
                            <td id="numCittaLivello2"></td>
                            <td id="numCittaLivello3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="space" style="height: 30px" ></div>

            <hr>

            <!-- SEGNALAZIONI CITTADINO -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color = "green" ><label for="cittadini">Statistiche per cittadino</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <select id="cittadini" onchange="segnalazioniCittadino(this)">
                        <?php
                        $query = "SELECT CF FROM Utente WHERE tipoUtente = 0";
                        $result = mysql_query($query);
                        $numRighe = mysql_num_rows($result);

                        echo '<option value="default">--------------------</option>';
                        for ($i = 0; $i < $numRighe; $i++) {
                            $cittadini = mysql_fetch_row($result);
                            $tmp = $cittadini[0];
                            echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                        }
                        ?>
                    </select>
                    <br><br>
                    <input placeholder="CF Cittadino"type="text" id="cfCittadino" oninput="segnalazioniCittadino(document.getElementById('cfCittadino'))">

                </div>          
            </div>


            <!-- TABELLA INFO CITTADINO -->
            <div class="table-responsive">          
                <table class="table">
                    <thead>
                        <tr>
                            <th># Segnalazioni</th>
                            <th>Attendibilit&agrave;</th>
                            <th>Valutazione media</th>
                            <th>Livello normale</th>
                            <th>Livello di attenzione</th>
                            <th>Livello di allerta</th>
                            <th>Livello di allarme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="rowCittadino">
                            <td id="numCittadino"></td>
                            <td id="attCittadino"></td>
                            <td id="valMedCittadino"></td>
                            <td id="numCitLivello0"></td>
                            <td id="numCitLivello1"></td>
                            <td id="numCitLivello2"></td>
                            <td id="numCitLivello3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>


            <!-- SEGNALAZIONI OPERATORE -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color ="green "> <label for="operatori">Statistiche per operatore</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-6">
                    <select id="operatori" onchange="segnalazioniOperatore(this)">
                        <?php
                        require_once './databaseconnection.php';

                        $query = "SELECT CF FROM Utente WHERE tipoUtente = 1";
                        $result = mysql_query($query);
                        $numRighe = mysql_num_rows($result);

                        echo '<option value="default">--------------------</option>';
                        for ($i = 0; $i < $numRighe; $i++) {
                            $operatori = mysql_fetch_row($result);
                            $tmp = $operatori[0];
                            echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color = "blue"> <label># segnalazioni</label></font>
                    <input type="text" id="numOperatore" disabled="true">
                </div>
            </div>

            <div class="space" style="height: 30px" ></div>

            <hr>


            <div class="space" style="height: 30px" ></div>

            <!-- SEGNALAZIONI DATA -->
             <div class="row">
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color =" green">  <label for="data">Statistiche per data</label></font>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-6">
                    <input type="date" id="data" oninput="segnalazioniData()" placeholder = "AAAA-MM-GG">
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-3">
                    <font color = "blue" ><label># segnalazioni</label></font>
                    <input type="text" id="numData" disabled="true" onchange="coloreCampo(document.getElementById('numData'))">
                </div>
            </div>

        </div>

        <hr><BR><BR><BR><BR>

        
        <script type="text/javascript">

            function segnalazioniOperatore(input) {

                var selected = input.value;

                if (selected === "default") {
                    document.getElementById("numOperatore").value = "";
                    return;

                } else {

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var response = parseInt(httpReq.responseText);


                            numOperatore = document.getElementById("numOperatore");
                            numOperatore.value = response;

                            if (response > 0) {
                                coloreCampo(numOperatore);
                            }

                        }
                    };

                    var url = "queryEmanuele.php?cfOperatore=" + selected;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();
                }
            }



            function segnalazioniCittadino(input) {

                var selected = input.value;

                if (selected === "default" || selected.length === 0) {
                    document.getElementById("numCittadino").value = "";
                    return;

                } else {

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var informazioni = JSON.parse(httpReq.responseText);

                            var tot = parseInt(informazioni[2]) + parseInt(informazioni[3])
                                    + parseInt(informazioni[4]) + parseInt(informazioni[5]);
                            document.getElementById("numCittadino").innerHTML = tot;
                            document.getElementById("attCittadino").innerHTML = informazioni[0];
                            document.getElementById("valMedCittadino").innerHTML = informazioni[1];

                            // INFORMAZIONI PER LIVELLO
                            document.getElementById("numCitLivello0").innerHTML = informazioni[2];
                            document.getElementById("numCitLivello1").innerHTML = informazioni[3];
                            document.getElementById("numCitLivello2").innerHTML = informazioni[4];
                            document.getElementById("numCitLivello3").innerHTML = informazioni[5];
                        }
                    };

                    var url = "queryEmanuele.php?cf=" + selected;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();
                }
            }


            function segnalazioniRegione(input) {

                var selected = input.value;

                if (selected === "default") {
                    document.getElementById("numRegione").value = "";

                    return;

                } else {

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var informazioni = JSON.parse(httpReq.responseText);

                            // INFORMAZIONI PER STATO
                            document.getElementById("numRegStato0").innerHTML = informazioni[0];
                            document.getElementById("numRegStato1").innerHTML = informazioni[1];
                            document.getElementById("numRegStato2").innerHTML = informazioni[2];
                            document.getElementById("numRegStato3").innerHTML = informazioni[3];

                            var tot = informazioni[0] + informazioni[1] + informazioni[2] + informazioni[3];
                            numRegione = document.getElementById("numRegione");
                            numRegione.value = tot;

                            if (tot > 0) {
                                coloreCampo(numRegione);
                            }

                            // INFORMAZIONI PER LIVELLO
                            document.getElementById("numRegLivello0").innerHTML = informazioni[4];
                            document.getElementById("numRegLivello1").innerHTML = informazioni[5];
                            document.getElementById("numRegLivello2").innerHTML = informazioni[6];
                            document.getElementById("numRegLivello3").innerHTML = informazioni[7];

                        }
                    };


                    var url = "queryEmanuele.php?allInfo=yes&regione=" + selected;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();

                    var httpReq1 = new XMLHttpRequest();

                    httpReq1.onreadystatechange = function () {

                        if (httpReq1.readyState == 4 && httpReq1.status == 200) {

                            var province = JSON.parse(httpReq1.responseText);

                            var select = document.getElementById("provincia");
                            while (select.hasChildNodes()) {
                                select.removeChild(select.firstChild);
                            }

                            var option = document.createElement("option");
                            option.setAttribute("value", "default");
                            option.appendChild(document.createTextNode("--------------"));
                            select.appendChild(option);

                            for (i = 0; i < province.length; i++) {

                                var option = document.createElement("option");
                                option.setAttribute("value", province[i]);
                                option.appendChild(document.createTextNode(province[i]));
                                select.appendChild(option);
                            }

                            select.disabled = false;
                        }
                    };

                    var url1 = "queryEmanuele.php?allPro=" + selected;
                    httpReq1.open("GET", url1, true);
                    httpReq1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq1.send();
                }
            }

            function segnalazioniProvincia(input) {

                var selected = input.value;

                if (selected === "default") {
                    document.getElementById("numProvincia").value = "";

                    return;

                } else {

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var informazioni = JSON.parse(httpReq.responseText);

                            // INFORMAZIONI PER STATO
                            document.getElementById("numProStato0").innerHTML = informazioni[0];
                            document.getElementById("numProStato1").innerHTML = informazioni[1];
                            document.getElementById("numProStato2").innerHTML = informazioni[2];
                            document.getElementById("numProStato3").innerHTML = informazioni[3];

                            var tot = informazioni[0] + informazioni[1] + informazioni[2] + informazioni[3];

                            numProvincia = document.getElementById("numProvincia");
                            numProvincia.value = tot;

                            if (tot > 0) {
                                coloreCampo(numProvincia);
                            }

                            // INFORMAZIONI PER LIVELLO
                            document.getElementById("numProLivello0").innerHTML = informazioni[4];
                            document.getElementById("numProLivello1").innerHTML = informazioni[5];
                            document.getElementById("numProLivello2").innerHTML = informazioni[6];
                            document.getElementById("numProLivello3").innerHTML = informazioni[7];

                        }
                    };

                    var url = "queryEmanuele.php?allInfo=yes&provincia=" + selected;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();
                }
            }

            function segnalazioniCitta() {

                var citta = document.getElementById("citta").value;

                if (citta.length == 0) {
                    document.getElementById("numCitta").value = "";

                    return;

                } else {
                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var informazioni = JSON.parse(httpReq.responseText);

                            // INFORMAZIONI PER STATO                          

                            document.getElementById("numCittaStato0").innerHTML = informazioni[0];
                            document.getElementById("numCittaStato1").innerHTML = informazioni[1];
                            document.getElementById("numCittaStato2").innerHTML = informazioni[2];
                            document.getElementById("numCittaStato3").innerHTML = informazioni[3];

                            var tot = informazioni[0] + informazioni[1] + informazioni[2] + informazioni[3];
                            numCitta = document.getElementById("numCitta");
                            numCitta.value = tot;

                            if (tot > 0) {
                                coloreCampo(numCitta);
                            }

                            // INFORMAZIONI PER LIVELLO
                            document.getElementById("numCittaLivello0").innerHTML = informazioni[4];
                            document.getElementById("numCittaLivello1").innerHTML = informazioni[5];
                            document.getElementById("numCittaLivello2").innerHTML = informazioni[6];
                            document.getElementById("numCittaLivello3").innerHTML = informazioni[7];

                        }
                    };

                    var url = "queryEmanuele.php?allInfo=yes&citta=" + citta;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();
                }
            }

            function segnalazioniData() {

                var data = document.getElementById("data").value;


                console.log(data);

                if (data.length == 0) {
                    document.getElementById("numData").value = "";

                    return;

                } else {

                    var httpReq = new XMLHttpRequest();

                    httpReq.onreadystatechange = function () {

                        if (httpReq.readyState == 4 && httpReq.status == 200) {

                            var response = parseInt(httpReq.responseText);
                            numData = document.getElementById("numData");
                            numData.value = response;
                            if (response > 0) {
                                coloreCampo(numData);
                            }
                        }
                    };

                    var url = "queryEmanuele.php?data=" + data;
                    httpReq.open("GET", url, true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send();
                }
            }


            function coloreCampo(input) {
                input.style.backgroundColor = "lightgreen";
                setTimeout(function () {
                    input.style.backgroundColor = "";
                }, 1000);
            }

            $(document).ready(function () {

                if (!localStorage.codiceFiscale || (localStorage.getItem("tipoUtente") != 2)) {
                    while (document.firstChild) {
                        document.removeChild(document.firstChild);
                    }
                    window.location = "errorPage.php";
                }
            });



        </script>
    </body>

</html>




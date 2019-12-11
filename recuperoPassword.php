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
        <link rel="stylesheet" href="extra.css">

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
                    <a class="navbar-brand">CittadinAPP</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">

                </div>
            </div>
        </nav>

        <div class="space" style="height: 30px" ></div>

        <div class ="container">

            <form action="">

                <div class="form-group">
                    <label for="cfNuovo">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="

                           <?php
                           require_once './databaseconnection.php';

                           if (isset($_GET['codice'])) {

                               $codice = $_GET['codice'];

                               $query = "SELECT email FROM CacheTemporanea WHERE codiceCasuale = '%s'";
                               $query = sprintf($query, $codice);
                               $result = mysql_query($query);
                               $info = mysql_fetch_row($result);

                               echo $info[0];
                           }
                           ?>" disabled="true">
                </div>
                <div class="form-group">
                    <label for="pass1">Nuova password</label>
                    <input type="password" class="form-control" id="pass1" name="pass1">
                </div>
                <div class="form-group">
                    <label for="pass1">Ripetere nuova password</label>
                    <input type="password" class="form-control" id="pass2" name="pass2">
                </div>

                <div class="media">
                    <div class="media-body"></div>
                    <div class="media-right">
                        <button type="button" onclick="cambiaPassword()" class="btn btn-default">Conferma</button>
                    </div>
                </div>

            </form>

            <div class="alert alert-danger" id="alertErrore" hidden="true">

            </div>

        </div>


    </body>

    <script type="text/javascript">

        function cambiaPassword() {
            
            var email = document.getElementById("email").value;
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;

            if (pass1.length == 0 || pass2.length == 0) {
                document.getElementById("alertErrore").innerHTML = "Inserire un <strong>valore</strong> in entrambi i campi.";
                document.getElementById("alertErrore").hidden = false;
                return;

            } else if (pass1 !== pass2) {
                document.getElementById("alertErrore").innerHTML = "Le due password <strong>non corrispondono</strong>.";
                document.getElementById("alertErrore").hidden = false;
                return;
            } else {

                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        var response = parseInt(httpReq.responseText);

                        switch (response) {
                            case 1:
                                alert("Riceverai una mail per completare la procedura di registrazione.");
                                $('#primoAccesso').modal('hide');
                                break;
                            case - 1:
                                document.getElementById("alertErroreDialog").innerHTML = "Il <strong>codice fiscale</strong> inserito risulta già registrato.";
                                document.getElementById("alertErroreDialog").hidden = false;
                                break;
                            case - 2:
                                document.getElementById("alertErroreDialog").innerHTML = "<strong>L'indirizzo email</strong> inserito è già associato ad un account.";
                                document.getElementById("alertErroreDialog").hidden = false;
                                break;
                            case - 3:
                                document.getElementById("alertErroreDialog").innerHTML = "Errore nell'invio della mail di conferma.";
                                document.getElementById("alertErroreDialog").hidden = false;
                                break;
                            case - 4:
                                document.getElementById("alertErroreDialog").innerHTML = "Errore generico";
                                document.getElementById("alertErroreDialog").hidden = false;
                                break;

                        }
                    }
                };
                httpReq.open("POST", "operazioniUtente.php", true);
                httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpReq.send("mailCambioPass=" + email + "&pass=" + pass1);
            }
        }

        /* var countdown = 5;
         
         setInterval(function () {
         if (countdown <= 0) {
         window.location = "index.php";
         }
         document.getElementById("counter").innerText = "A breve verrai reindirizzato alla pagina di login: " + countdown--;
         }, 1000); */


    </script>
</html>
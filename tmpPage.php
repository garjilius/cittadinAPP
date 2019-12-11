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


        <div class ="container">

            <?php
            if (isset($_GET['esito'])) {
                
                $esito = $_GET['esito'];
                
                if($esito == 0) {
                    
                    echo '<h3 class="bg-success">Registrazione completata!</h3><h5 id="counter"></h5>';
                    
                } else if ($esito == 1) {
                    
                    echo '<h3 class="bg-danger">Qualcosa &eacute; andato storto!</h3><h5 id="counter"></h5>';
                }
            }
            ?>
            
        </div>


    </body>

    <script type="text/javascript">

        var countdown = 5;

        setInterval(function () {
            if (countdown <= 0) {
                window.location = "index.php";
            }
            document.getElementById("counter").innerText = "A breve verrai reindirizzato alla pagina di login: " + countdown--;
        }, 1000);


    </script>
</html>



<?php

if (isset($_POST['email'])) {

    $destinatario = $_POST['email'];

    $oggetto = "Recupero password CittadinAPP";

    $messaggio = '<html><head>
        <title>Procedura recupero password CittadinAPP</title>
    </head>
    <body>
        <h3>MESSAGGIO GENERATO AUTOMATICAMENTE! NON RISPONDERE!</h3>
        <p>Per recuperare la passoword, clicca sul link seguente:</p>
        <a style="text-decoration: underline">Link recupero</a>
    </body>
    </html>';

    /* Per inviare email in formato HTML, si deve impostare l'intestazione Content-type. */
    $intestazioni = "MIME-Version: 1.0\r\n";
    $intestazioni .= "Content-type: text/html; charset=iso-8859-1\r\n";

    $esito = mail($destinatario, $oggetto, $messaggio, $intestazioni);

    echo $esito;
}
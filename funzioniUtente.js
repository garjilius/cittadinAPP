

$(document).ready(function () {
    if (localStorage.getItem("cittadinApp")) {
        console.log(localStorage.cittadinApp);        
    } else {
        alert("CONNESSIONE SCADUTA! Effettuare nuovamente il login!");
        window.location = "index.php";
    }
    
});

function mieSegnalazioni() {

    var url = "elencoSegnalazioniUtente.php?cf=" + localStorage.cittadinApp;
    window.location = url;
}

function logout() {
    localStorage.removeItem("cittadinApp");
    window.location = "index.php";
}



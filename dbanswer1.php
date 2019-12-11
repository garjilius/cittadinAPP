<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$str_query = file_get_contents('php://input');

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'; 
include 'databaseconnection.php';
$response = mysql_query($str_query) or die ("Impossibile fare la query");


?>


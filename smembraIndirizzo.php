<?php

if (isset($_POST['json'])) {

    $json = $_POST['json'];
    
    $indirizzo = json_decode($json);

    $streetNumber = NULL;
    $route = NULL;
    $locality = NULL;
    $areaLevel3 = NULL;
    $areaLevel2 = NULL;
    $areaLevel1 = NULL;
    $country = NULL;
    $postalCode = NULL;

    for ($i = 0; $i < count($indirizzo); $i++) {

        if ((strcmp("street_number", $indirizzo[$i]->types[0])) == 0) {

            $streetNumber = $indirizzo[$i]->short_name;
        } else if ((strcmp("route", $indirizzo[$i]->types[0])) == 0) {

            $route = $indirizzo[$i]->short_name;
        } else if ((strcmp("locality", $indirizzo[$i]->types[0])) == 0) {

            $locality = $indirizzo[$i]->short_name;
        } else if ((strcmp("administrative_area_level_3", $indirizzo[$i]->types[0])) == 0) {

            $areaLevel3 = $indirizzo[$i]->short_name;
        } else if ((strcmp("administrative_area_level_2", $indirizzo[$i]->types[0])) == 0) {

            $areaLevel2 = $indirizzo[$i]->short_name;
        } else if ((strcmp("administrative_area_level_1", $indirizzo[$i]->types[0])) == 0) {

            $areaLevel1 = $indirizzo[$i]->short_name;
        } else if ((strcmp("country", $indirizzo[$i]->types[0])) == 0) {

            $country = $indirizzo[$i]->short_name;
        } else if ((strcmp("postal_code", $indirizzo[$i]->types[0])) == 0) {

            $postalCode = $indirizzo[$i]->short_name;
        }
    }

    echo $areaLevel3 . "-" . $areaLevel2;
}

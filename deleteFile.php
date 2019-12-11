<?php

if (isset($_GET['fileName'])) {

    $file = $_GET['fileName'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file);

    if (file_exists($target_file)) {

        if (!unlink($target_file)) {
            echo -1;
        } else {
            echo 0;
        }
    }
}

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename(trim($_FILES["fileToUpload"]["name"]));
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check == false) {
    echo -1;
} //else if (file_exists($target_file)) {
    //echo -2;
 else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo 0;
} else {
    echo -3;
}

?>


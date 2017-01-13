<?php

$uploaddir = 'uploads';
$extension_array = explode(".", $_FILES['file']['name']);
$extension = ".".$extension_array[count($extension_array)-1];
$file_name = time().$extension;
$uploadfile = $uploaddir . "/" . basename($file_name);

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo json_encode(["status"=>1, "name"=>$file_name]);
} else {
    echo json_encode(["status"=>2]);
}

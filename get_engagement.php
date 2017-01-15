<?php
$url = $_POST['url'];
$status = 0;
$response = file_get_contents($url);
if($response) {
    $response = json_decode($response);
    $status = 1;
}
echo json_encode(['status'=>$status, 'text'=>$response]);
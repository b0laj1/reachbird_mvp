<?php
if(! $_SESSION) {
    session_start();
}

$_SESSION['user_id'] = $_POST['user_id'];

echo json_encode(['status'=>1, 'text'=>'done']);
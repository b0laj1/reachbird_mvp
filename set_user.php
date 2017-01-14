<?php
if(! $_SESSION) {
    session_start();
}
if($_POST['user_id'] == 'Select Influencer Account'){
    unset($_SESSION['user_id']);
} else{
    $_SESSION['user_id'] = $_POST['user_id'];
}

echo json_encode(['status'=>1, 'text'=>'done']);
<?php

if(!users::is_auth($auth_user))
    exit;

$id = $_GET['id'];

forum::add_favorite($user_id, $id);

echo json_encode('true');
    
?>
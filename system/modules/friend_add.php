<?php

if(!users::is_auth($auth_user))
    exit;

users::add_friend($user_id, $_GET['id']);

echo json_encode('true');

?>
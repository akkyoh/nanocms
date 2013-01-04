<?php

if(!users::is_auth($auth_user))
    exit;

if(!photos::exist_photo($user_id, $_GET['id']) and !users::is_admin($user_id)){
    echo json_encode('Неверная фотография для удаления.'); 
    exit;
}

photos::delete($_GET['id']);

?>

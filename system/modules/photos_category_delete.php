<?php

if(!users::is_auth($auth_user))
    exit;

if(!photos::exist_category($user_id, $_GET['id']) and !users::is_admin($user_id)){
    echo json_encode('Неверный раздел для удаления.'); 
    exit;
}

photos::delete_category($_GET['id']);

?>

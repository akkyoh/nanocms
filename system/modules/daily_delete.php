<?php

if(!users::is_auth($auth_user))
    exit;

if(!daily::exist_note($user_id, $_GET['id']) and !users::is_admin($user_id)){
    echo json_encode('Неверная запись для удаления.'); 
    exit;
}

daily::delete($_GET['id']);

?>

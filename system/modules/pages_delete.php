<?php

if(!users::is_admin($user_id))
    exit;

if(!pages::exist_page($_GET['id'])){
    echo json_encode('Неверная страница для удаления.'); 
    exit;
}

pages::delete($_GET['id']);

?>

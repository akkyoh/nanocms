<?php

if(!users::is_admin($user_id))
    exit;

if(!files::exist_category($_GET['id'])){
    echo json_encode('Неверная категория для удаления.'); 
    exit;
}

files::delete_category($_GET['id']);

?>

<?php

if(!users::is_admin($user_id))
    exit;

if(!files::exist_file($_GET['id'])){
    echo json_encode('Неверный файл для удаления.'); 
    exit;
}

files::delete($_GET['id']);

?>

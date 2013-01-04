<?php

if(!users::is_admin($user_id))
    exit;

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$id = $_POST['id'];

if(mb_strlen($name, 'UTF-8') > 64)
    die(json_encode('Название категории не должно превышать 64 символа.'));
if(empty($name))
    die(json_encode('Название не может быть пустым.'));
if(mb_strlen($description, 'UTF-8') > 512)
    die(json_encode('Описание категории не должно превышать 512 символов.'));
if(!empty($id) and !forum::exist_category($id))
    die(json_encode('Категория не существует.'));
    
forum::add_category($id, $name, $description);

echo json_encode('true');

?>
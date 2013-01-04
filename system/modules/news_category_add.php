<?php

if(!users::is_admin($user_id))
    exit;

$about = trim($_POST['about']);
$name = trim($_POST['name']);
$id = $_POST['id'];

if(mb_strlen($about, 'UTF-8') > 512)
    die(json_encode('Описание не должно превышать 512 символов.'));
if(mb_strlen($name, 'UTF-8') > 192)
    die(json_encode('Название не должно превышать 192 символов.'));
if(empty($name))
    die(json_encode('Название не может быть пустым.'));
if(!empty($id) and !news::exist_category($id))
    die(json_encode('Категория не существует.'));
        
news::add_category($id, $name, $about);

echo json_encode('true');

?>
<?php

if(!users::is_auth($auth_user))
    exit;

$about = $_POST['about'];
$name = trim($_POST['name']);
$id = $_POST['id'];

if(mb_strlen($about, 'UTF-8') > 512)
    die(json_encode('Описание не должно превышать 512 символов.'));
if(mb_strlen($name, 'UTF-8') > 192)
    die(json_encode('Название не должно превышать 192 символов.'));
if(empty($name))
    die(json_encode('Название не может быть пустым.'));
if(!empty($id) and !daily::exist_category($user_id, $id))
    die(json_encode('Категория не существует.'));

daily::add_category($id, $user_id, $name, $about);

echo json_encode('true');

?>
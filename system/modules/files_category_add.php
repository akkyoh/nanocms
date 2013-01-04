<?php

if(!users::is_admin($user_id))
    exit;

$about = $_POST['about'];
$name = trim($_POST['name']);
$parent = $_POST['parent'];
$filetypes = $_POST['filetypes'];
$id = $_POST['id'];

if(mb_strlen($about, 'UTF-8') > 512)
    die(json_encode('Описание не должно превышать 512 символов.'));
if(mb_strlen($name, 'UTF-8') > 192)
    die(json_encode('Название не должно превышать 192 символов.'));
if(empty($name))
    die(json_encode('Название не может быть пустым.')); 
if(!preg_match("/^(\w+,+\s?)*(\w+,?)?$/i", $filetypes) and !empty($filetypes))
    die(json_encode('Неверно введены расширения файлов.')); 
if($parent > 0 and !files::exist_category($parent))
    die(json_encode('Родительская категория не существует.'));
if(!empty($id) and !files::exist_category($id))
    die(json_encode('Категория не существует.'));

files::add_category($id, $parent, $name, $about, $filetypes);

echo json_encode('true');

?>
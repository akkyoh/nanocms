<?php

if(!users::is_admin($user_id))
    exit;

if($config['demo'] == 'TRUE')
    exit;

$id = $_POST['id'];
$name = trim($_POST['name']);
$module = trim($_POST['module']);
$page_id = $_POST['page'];
$image = trim($_POST['image']);
$about = trim($_POST['about']);
if($_POST['module_custom'] != '')
    $module = trim($_POST['module_custom']);
if($module == 'divider')
    $module = '';

if($module == '')
{
    $page_id = NULL;
    $image = NULL;
    $about = NULL;
}

if(mb_strlen($name, 'UTF-8') > 64 or mb_strlen($name, 'UTF-8') < 3)
    die(json_encode('Длина названия меню не может быть менее 3 и не более 64 символов.'));
if(!is_numeric($page_id) and !empty($page_id))
    die(json_encode('Неверная страница.'));
if(mb_strlen($module, 'UTF-8') > 64)
    die(json_encode('Длина модуля не может быть более 64 символов.'));
if(mb_strlen($image, 'UTF-8') > 192)
    die(json_encode('Длина картинки не может быть более 192 символов.'));
if(mb_strlen($about, 'UTF-8') > 64)
    die(json_encode('Длина информации не может быть более 64 символов.'));

menu::add($id, $name, $module, $page_id, $image, $about);

echo json_encode('true');

?>

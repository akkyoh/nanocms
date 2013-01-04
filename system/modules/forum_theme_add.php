<?php

if(!users::is_auth($auth_user))
    exit;

$id = $_GET['id'];
$text = trim($_POST['text']);
$name = trim($_POST['name']);

if(mb_strlen($text, 'UTF-8') > 10240)
    die(json_encode('Сообщение не должно превышать 10240 символов.'));
if(empty($text))
    die(json_encode('Сообщение не может быть пустым.'));
if(mb_strlen($name, 'UTF-8') > 128)
    die(json_encode('Название не должно превышать 128 символов.'));
if(empty($name))
    die(json_encode('Название не может быть пустым.'));
if(!forum::exist_category($id))
    die(json_encode('Неверный раздел для создания темы.'));
if(!antiflood('forum_theme', $text, $user_id))
    die(json_encode('Ваше сообщение было отправлено.'));

$db -> transaction_start();

$theme_id = forum::add_theme($user_id, $name, $id);

if($theme_id != false)
    if(forum::add_message($user_id, $_POST['text'], $theme_id) != false)
        $db -> transaction_complete();
    else
        $db -> transaction_cancel();
else
    $db -> transaction_cancel();

echo json_encode('true');
    
?>
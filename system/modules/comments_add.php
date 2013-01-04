<?php

if(!users::is_auth($auth_user))
    exit;

$id = $_GET['id'];
$text = $_POST['text'];
$type = $_GET['type'];

if(mb_strlen($text, 'UTF-8') > 512)
    die(json_encode('Сообщение не должно превышать 512 символов.'));
if(empty($text))
    die(json_encode('Сообщение не может быть пустым.'));
if(!comments::exist_type($type))
    die(json_encode('Неверный раздел для отправки комментария.'));
if(!antiflood('comments_'.$type, $text, $user_id))
    die(json_encode('Ваше сообщение было отправлено.'));

comments::add($id, $type, $user_id, $text);

echo json_encode('true');

?>
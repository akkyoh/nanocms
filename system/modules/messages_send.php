<?php

if(!users::is_auth($auth_user))
    exit;

$user_d = $_GET['id'];
$text = trim($_POST['text']);

if(mb_strlen($text, 'UTF-8') > 10240)
    die(json_encode('Сообщение не должно превышать 10240 символов.'));
if(empty($text))
    die(json_encode('Сообщение не может быть пустым.'));
if(!antiflood('messages', $text, $user_id))
    die(json_encode('Ваше сообщение было отправлено.'));

messages::send_message($user_id, $user_d, $text);

echo json_encode('true');

?>
<?php

if(!users::is_auth($auth_user))
    exit;

$text = $_POST['text'];

if(mb_strlen($text, 'UTF-8') > 512)
    die(json_encode('Сообщение не должно превышать 512 символов.'));
if(empty($text))
    die(json_encode('Сообщение не может быть пустым.'));
if(!antiflood('chat', $text, $user_id))
    die(json_encode('Ваше сообщение было отправлено.'));

chat::add($user_id, $text);

echo json_encode('true');

?>
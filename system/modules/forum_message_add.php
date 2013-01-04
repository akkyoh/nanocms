<?php

if(!users::is_auth($auth_user))
    exit;

$text = $_POST['text'];
$theme = $_GET['theme'];

if(mb_strlen($text, 'UTF-8') > 10240)
    die(json_encode('Сообщение не должно превышать 512 символов.'));
if(empty($text))
    die(json_encode('Сообщение не может быть пустым.'));
if(!antiflood('forum_message', $text, $user_id))
    die(json_encode('Ваше сообщение было отправлено.'));

$theme_data = forum::get_themes_data($theme);

if(empty($theme_data['id']) or $theme_data['close'] == 1){
    echo json_encode('Неверная тема для отправки сообщения.'); 
    exit;
}

forum::add_message($user_id, $text, $theme);

echo json_encode('true');

?>
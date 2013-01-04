<?php

if(!users::is_auth($auth_user))
    exit;

$id = $_GET['id'];
$text = trim($_POST['text']);
$category = $_POST['category'];
$topic = trim($_POST['topic']);

if(!empty($_POST['comments']))
    $comments = 1;
else
    $comments = 0;

if(!empty($_POST['public']))
    $hide = 1;
else
    $hide = 0;

if(mb_strlen($text, 'UTF-8') > 10240){
    echo json_encode('Текст новости не должен превышать 10240 символов.'); 
    exit;
}
if(empty($text)){
    echo json_encode('Текст новости не может быть пустым.'); 
    exit;
}
if(mb_strlen($topic, 'UTF-8') > 192){
    echo json_encode('Заголовок не должен превышать 192 символов.'); 
    exit;
}
if(empty($topic)){
    echo json_encode('Заголовок не может быть пустым.'); 
    exit;
}
if(!daily::exist_category($user_id, $category)){
    echo json_encode('Неверный раздел для создания записи.'); 
    exit;
}
if(!daily::exist_note($user_id, $id) and !empty($id)){
    echo json_encode('Неверная запись для сохранения.'); 
    exit;
}

$note_id = daily::update($user_id, $id, $topic, $text, $category, $comments, $hide);

echo json_encode(array('true', generate_url($note_id.'_'.$topic)));

?>
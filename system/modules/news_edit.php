<?php

if(!users::is_admin($user_id))
    exit;

$id = $_GET['id'];
$text = $_POST['text'];
$category = $_POST['category'];
$topic = $_POST['topic'];

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
if(!news::exist_category($category)){
    echo json_encode('Неверный раздел для создания новости.'); 
    exit;
}
if(!news::exist_news($id) and !empty($id)){
    echo json_encode('Неверная новость для сохранения.'); 
    exit;
}

$news_id = news::update($user_id, $id, $topic, $text, $category, $comments, $hide);

echo json_encode(array('true', generate_url($news_id.'_'.$topic)));

?>
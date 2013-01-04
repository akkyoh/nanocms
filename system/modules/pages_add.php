<?php

if(!users::is_admin($user_id))
    exit;

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$keywords = $_POST['keywords'];
$page = $_POST['page'];

if(mb_strlen($title, 'UTF-8') > 10240 or empty($title))
    die(json_encode('Заголовок не должен быть пустым или превышать 248 символов.'));
if(mb_strlen($description, 'UTF-8') > 248)
    die(json_encode('Описание не должно превышать 248 символов.'));
if(mb_strlen($keywords, 'UTF-8') > 2048)
    die(json_encode('Ключевые слова не должны превышать 2048 символов.'));
if(!empty($id) and !pages::exist_page($id))
    die(json_encode ('Страница не существует.'));

$page_id = pages::add($id, $title, $description, $keywords, $page);

echo json_encode(array('true', generate_url($page_id.'_'.$title)));

?>
<?php

if(!users::is_admin($user_id))
    exit;

$id = $_POST['id'];
$field = $_POST['field'];
$value = $_POST['value'];

if($field == 'name' and (mb_strlen($value, 'UTF-8') > 192 or mb_strlen($value, 'UTF-8') < 3)){
    echo json_encode('Название файла не должно быть менее 3 символов и не более 192 символов.'); 
    exit;
}
if($field == 'description' and mb_strlen($value, 'UTF-8') > 512){
    echo json_encode('Описание файла не должно быть не более 512 символов.'); 
    exit;
}
if(!files::exist_file($id) and !empty($id)){
    echo json_encode('Неверный файл.'); 
    exit;
}

files::update($id, $field, $value);

echo json_encode('true');

?>
<?php

if(!users::is_auth($auth_user))
    exit;

$id = $_POST['id'];
$field = $_POST['field'];
$value = $_POST['value'];

if($field == 'name' and (mb_strlen($value, 'UTF-8') > 192 or mb_strlen($value, 'UTF-8') < 3)){
    echo json_encode('Название фотографии не должно быть менее 3 символов и не более 192 символов.'); 
    exit;
}
if($field == 'description' and mb_strlen($value, 'UTF-8') > 512){
    echo json_encode('Описание фотографии не должно быть не более 512 символов.'); 
    exit;
}
if(!photos::exist_photo($user_id, $id) and !empty($id)){
    echo json_encode('Неверная фотография.'); 
    exit;
}

photos::update($id, $field, $value);

echo json_encode('true');

?>
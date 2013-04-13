<?php

$id = intval($_GET['id']);
$size = $_GET['size'];
$photo_data = photos::photo_data($id);

if(!empty($size) and
   ($size == 128 or
   $size == 240 or
   $size == 360 or
   $size == 640))
    $filename = $id.'_'.$size.'.jpg';
elseif($size == 'preview')
   $filename = $id.'_preview.jpg';
else
    $filename = $id.'.jpg';

if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$filename))
    die('Ошибка, файл не найден.');

if(ob_get_level())
    ob_end_clean();

header('Content-Length: '.filesize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$filename)); 
//header('Accept-Ranges: bytes');
 
header('Content-Type: image/jpeg');

if(isset($_GET['download']))
    header('Content-disposition: attachment; filename="'.urlencode(protect_echo($photo_data['name'])).'"');

if ($fd = fopen($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$filename, 'rb')) {
    while (!feof($fd))
        print fread($fd, 4096);
    fclose($fd);
}

exit;

?>
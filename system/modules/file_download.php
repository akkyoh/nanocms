<?php

$id = intval($_GET['id']);
$file_data = files::file_data($id);
if(isset($_GET['preview']))
{
    $filename = $id.'.preview';
    $mime = files::get_mimetype('jpg');
    $size = filesize($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$filename);
    $filetype = 'jpg';
}
else
{
    $filename = $id.'.download';
    $mime = files::get_mimetype($file_data['filetype']);
    $size = $file_data['size'];
    $filetype = $file_data['filetype'];
}

if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$filename))
    die('Ошибка, файл не найден.');

if(ob_get_level())
    ob_end_clean();

 header('Content-Length: '.$size);

if(!empty($mime))
    header('Content-Type: '.$mime);
if(!isset($_GET['show']) and !isset($_GET['preview']))
    header('Content-disposition: attachment; filename="'.$file_data['name'].'.'.$filetype.'"');

if ($fd = fopen($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$filename, 'rb')) {
    while (!feof($fd))
        print fread($fd, 4096);
    fclose($fd);
}

files::download_count($id);

exit;

?>
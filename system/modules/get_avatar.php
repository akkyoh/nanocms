<?php

$user = intval($_GET['id']);
$size = intval($_GET['size']);

$user_d = new users($user, 'sex');

if(ob_get_level())
    ob_end_clean();

if(file_exists('./system/files/avatars/'.$user.'.jpg') and $size == 0)
    $file_path = './system/files/avatars/'.$user.'.jpg';
elseif(file_exists('./system/files/avatars/'.$user.'_medium.jpg') and $size == 1)
    $file_path = './system/files/avatars/'.$user.'_medium.jpg';
elseif(file_exists('./system/files/avatars/'.$user.'_small.jpg') and $size == 2)
    $file_path = './system/files/avatars/'.$user.'_small.jpg';
elseif($user_d -> get_sex() == '1')
    $file_path = './static/images/male.png';
elseif($user_d -> get_sex() == '2')
    $file_path = './static/images/female.png';

header('Content-Type: image/'.str_replace('jpg', 'jpeg' ,substr(strrchr($file_path, '.'), 1)));
header('Content-Length: '.filesize($file_path)); 

if ($fd = fopen($file_path, 'rb')) {
    while (!feof($fd))
        print fread($fd, 4096);
    fclose($fd);
}

exit;

?>
<?php

$db_host = $_POST['server'];
$db_name = $_POST['database'];
$db_user = $_POST['username'];
$db_password = $_POST['password'];

$name = $_POST['name'];
$password = $_POST['user_password'];
$mail = $_POST['mail'];
$sex = $_POST['sex'];

$title = $_POST['title'];
$status = install::status();

$error = NULL;

if(!empty($db_host) and !empty($db_host) and !empty($db_host) and !empty($db_host))
    $db = new db($db_host, $db_user, $db_password, $db_name);

if(empty($db_host))
    $error .= 'Не введен сервер для соединения с базой данных<br>';
if(empty($db_name))
    $error .= 'Не введено название базы данных<br>';
if(empty($db_user))
    $error .= 'Не введено имя пользователя для соединения с базой данных<br>';
if(empty($db_password))
    $error .= 'Не введен сервер для соединения с базой данных<br>';
if($db -> connect == FALSE)
    $error .= 'Ошибка при соединении. Данные для соединения с базой данных введены неверно<br>';

if(!$status['config'])
    $error .= 'Файл /system/config.ini недоступен для записи';
if(!$status['avatar'])
    $error .= 'Папка /system/files/avatars/ недоступна для записи';
if(!$status['files'])
    $error .= 'Папка /system/files/files/ недоступна для записи';
if(!$status['photos'])
    $error .= 'Папка /system/files/photos/ недоступна для записи';
if(!$status['temporary'])
    $error .= 'Папка /system/files/temporary/ недоступна для записи';
if(!$status['cache'])
    $error .= 'Папка /system/files/cache/ недоступна для записи';
if(!$status['logs'])
    $error .= 'Папка /system/logs/ недоступна для записи';
if(!$status['installed'])
    $error .= 'Установка невозможна. Система уже установлена.';

if(mb_strlen($name, 'UTF-8') < 3 or mb_strlen($name, 'UTF-8') > 32)
    $error .= 'Длина имени пользователя не может быть менее 3 и не более 32 символов<br>';
if(mb_strlen($password, 'UTF-8') < 6 or mb_strlen($password, 'UTF-8') > 32)
    $error .= 'Длина пароля не может быть менее 6 и не более 32 символов<br>';
if($sex != 1 and $sex != 2)
    $error .= 'Пол выбран неверно<br>';
if(!filter_var($mail, FILTER_VALIDATE_EMAIL) and !empty($mail))
    $error .= 'Неверно введен почтовый ящик<br>';
if(!preg_match("/^[A-ZА-Я0-9 _-]+$/iu", $name))
    $error .= 'Имя пользователя может содержать только буквы латинского алфавита, кириллического алфавита, цифры и символы "_", "-", " "<br>';
if(preg_match("/[А-Я]/i", $name) and preg_match("/[A-Z]/i", $name))
    $error .= 'Имя пользователя может содержать только буквы латинского алфавита или только буквы кириллического алфавита<br>';

if($error != NULL)
    
    echo json_encode($error);

else{
    
    $config = array('db_host' => $db_host,
                    'db_name' => $db_name,
                    'db_user' => $db_user,
                    'db_password' => $db_password,
                    'name' => $title);

    if(file_get_contents('http://nanocms.mobi/modules/licence_check/?domain='.$_SERVER['HTTP_HOST']) == 'TRUE')
         $config['licence'] = 'TRUE';
    
    if(install::sql('./system/sql/database.sql'))
    {
        
        if(users::add_user($name, $password, $mail, $sex))
        {
                
            $user = new users(1, 'level');
            $user -> set_level(7);
            $user -> update();

            users::auth($name, $password);

            write_config($config, '.');

            die(json_encode('true'));
        
        }
        
    }
    
    echo json_encode('Ошибка при установке базы данных.');
    
}

?>
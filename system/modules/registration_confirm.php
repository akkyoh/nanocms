<?php

$name = $_POST['name'];
$password = $_POST['password'];
$sex = $_POST['sex'];
$mail = $_POST['mail'];

$error = NULL;

if($config['demo'] == 'TRUE')
    $error .= 'Регистрация в DEMO режиме невозможна.';
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

$name_not_empty = $db -> query("SELECT 1 from `users` WHERE `login`=?", $name);

if(!empty($name_not_empty))
    $error .= 'Имя пользователя занято<br>';

$mail_not_empty = $db -> query("SELECT 1 from `users` WHERE `mail`=?", $mail);

if(!empty($mail_not_empty) and !empty($mail))
    $error .= 'Почтовый ящик уже используется<br>';

if($error != NULL)
    
    echo json_encode($error);

else{
    
    if(!antiflood('registration', '', ip2long(get_ip())))
        die(json_encode('С вашего IP слишком много запросов на регистрацию.'));
    
    users::add_user($name, $password, $mail, $sex);
    users::auth($name, $password);
    
    echo json_encode('true');
    
}

?>

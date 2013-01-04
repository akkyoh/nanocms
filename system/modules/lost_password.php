<?php

$n_or_m = $_POST['name'];

$status = $db -> query("SELECT `id`,`mail`,`login` from `users` WHERE `login` = ? or `mail` = ? LIMIT 1", $n_or_m, $n_or_m);

if(empty($status))
    die(json_encode('Имя пользователя или почтовый ящик не найдены.'));
else
{
    
    $name = $status[0]['login'];
    $mail = $status[0]['mail'];
    
    $key = random_string(32, 'lower,upper,numbers');
    $password = random_string(8, 'lower,upper,numbers');
    
    $subject = 'Восстановление пароля - '.$_SERVER['HTTP_HOST'];
$text = 'Восстановление пароля

Имя пользователя: '.$name.'
Новый пароль: '.$password.'

Для активации нового пароля в течении суток перейдите по ссылке: http://'.$_SERVER['HTTP_HOST'].'/activate_password/?id='.$status[0]['id'].'&key='.$key.'

Постарайтесь больше не забывать свой пароль!
 
Вы получили данное письмо, так как являетесь зарегистрированным участником проекта.
С уважением, администрация проекта http://'.$_SERVER['HTTP_HOST'];
    
    send_mail($_SERVER['HTTP_HOST'],
              'robot@'.$_SERVER['HTTP_HOST'],
              $name,
              $mail,
              'utf-8',
              'utf-8',
              $subject,
              $text);
    
    $db -> query('INSERT INTO `users_lost` (`id`, `key`, `password`, `time`) VALUES (?, ?, ?, UNIX_TIMESTAMP()+3600*24) ON DUPLICATE KEY UPDATE `id` = ?, `key` = ?, `password` = ?, `time` = UNIX_TIMESTAMP()+3600*24;', $status[0]['id'], $key, $password, $status[0]['id'], $key, $password);

    echo json_encode('Новый пароль выслан на ваш почтовый ящик. Подтвердите его в течении 24-х часов.');
    
}

?>

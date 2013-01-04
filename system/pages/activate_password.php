<? 
    head('Активация пароля', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content" id="container">

    <?
    
    $key = $_GET['key'];
    $user = $_GET['id'];
    
    $q = $db -> query("SELECT `key`,`password` from `users_lost` WHERE `id`= ?;", $user);

    if (empty($q) or $key != $q[0]['key'])
    {

    ?>
        
        <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li>Ключ восстановления неверен</li>
             
        </ul>
      
    <?
    
    }
    else
    {

        $db -> query("DELETE from `users_lost` WHERE `id` = ?;", $user);

        $subject = 'Активация нового пароля - '.$_SERVER['HTTP_HOST'];
        $text = 'Новый пароль активирован

Новый пароль: '.$q[0]['password'].'

Вы получили данное письмо, так как являетесь зарегистрированным участником проекта.
С уважением, администрация проекта http://'.$_SERVER['HTTP_HOST'];

        $user_d = new users($user, 'login, mail');
        
        send_mail($_SERVER['HTTP_HOST'],
                  'robot@'.$_SERVER['HTTP_HOST'],
                  $user_d -> get_name(),
                  $user_d -> get_mail(),
                  'utf-8',
                  'utf-8',
                  $subject,
                  $text);

        users::auth($user, $q[0]['password']);
        
        $db -> query("UPDATE `users` SET `password` = ? WHERE `id` = ?;", $user, encrypt_password($q[0]['password']));
        
        ?>
    
        <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li>Новый пароль активирован</li>
             
        </ul>
    
        <?
        
    }

    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Навигация</li>

        <li><a href="/">Меню</a></li>
             
    </ul>
    
</div>

<? 
    footer();
?>
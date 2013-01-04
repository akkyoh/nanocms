<? 

    head('Установка');
    
    $status = install::status();

?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="install" action="#" method="post">
    
    <ul data-role="listview" data-inset="true"> 

     <?
        
        if(!$status['result'])
        {
            
            echo '<li data-role="list-divider">Ошибки</li>';

            if(!$status['config'])
                echo '<li data-icon="false" style="font-weight: normal">Файл <u>/system/config.ini</u> недоступен для записи</li>';
            if(!$status['avatar'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/files/avatars/</u> недоступна для записи</li>';
            if(!$status['files'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/files/files/</u> недоступна для записи</li>';
            if(!$status['photos'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/files/photos/</u> недоступна для записи</li>';
            if(!$status['temporary'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/files/temporary/</u> недоступна для записи</li>';
            if(!$status['cache'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/files/cache/</u> недоступна для записи</li>';
            if(!$status['logs'])
                echo '<li data-icon="false" style="font-weight: normal">Папка <u>/system/logs/</u> недоступна для записи</li>';
            if(!$status['installed'])
                echo '<li data-icon="false" style="font-weight: normal">Установка невозможна. Система уже установлена.</li>';

            echo '</ul>';
            
        }
        else
        {
            
            ?>
            
            <li data-role="list-divider">База данных</li>
            
            <li data-role="fieldcontain">
                <label for="server">Сервер</label>
                <input type="text" name="server" id="server" value="localhost"/>
                <p id="server_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="database">База данных</label>
                <input type="text" name="database" id="database" value=""/>
                <p id="database_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="username">Имя пользователя</label>
                <input type="text" name="username" id="username" value=""/>
                <p id="username_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" value=""/>
                <p id="password_error" class="error_message"></p>
            </li>
            
            <li data-role="list-divider">Администратор</li>
            
            <li data-role="fieldcontain">
                <label for="name">Имя пользователя</label>
                <input type="text" name="name" id="name" value=""/>
                <p id="name_error" class="error_message"></p>
            </li>
                
            <li data-role="fieldcontain">
                <label for="user_password">Пароль</label>
                <input type="password" name="user_password" id="user_password" value=""  />
                <p id="user_password_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="mail">Почтовый ящик</label>
                <input type="text" name="mail" id="mail" value=""  />
                <p id="mail_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="sex" class="select">Пол</label>
                <select name="sex" id="sex" data-native-menu="false">
                    <option value="1">мужской</option>
                    <option value="2">женский</option>
                </select>
            </li>
            
            <li data-role="list-divider">Прочее</li>
            
            <li data-role="fieldcontain">
                <label for="title">Название сайта</label>
                <input type="text" name="title" id="title" value=""/>
                <p id="title_error" class="error_message"></p>
            </li>
            
            </ul>
            
            <input type="submit" id="submit" value="Продолжить" />
            
            </form>
            
            <?
            
        }
        
    ?>
    
</div>

<script type="text/javascript" src="/static/js/custom/install.js"></script>
<script type="text/javascript" src="/static/js/validation/install.js"></script>

<? 
    footer();
?>
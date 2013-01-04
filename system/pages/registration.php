<? 
    head('Регистрация', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="registration" action="#" method="post">
        
        <ul data-role="listview" data-inset="true">
        
            <li data-role="list-divider">Данные пользователя</li>
            
            <li data-role="fieldcontain">
                <label for="name">Имя пользователя</label>
                <input type="text" name="name" id="name" value=""/>
                <p id="name_error" class="error_message"></p>
            </li>
                
            <li data-role="fieldcontain">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" value=""  />
                <p id="password_error" class="error_message"></p>
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
    
        </ul>

        <input type="submit" id="submit" value="Продолжить" />
        
    </form>
   
</div>

<script type="text/javascript" src="/static/js/custom/registration.js"></script>
<script type="text/javascript" src="/static/js/validation/registration.js"></script>

<?
    footer();
?>
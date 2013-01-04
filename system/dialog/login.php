<? 
    head('Авторизация');
?>

<div data-role="content">	

    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form action="#" method="post" id="login">
                
        <div data-role="fieldcontain" class="ui-hide-label">
            <label for="login">Имя пользователя или почтовый ящик</label>
            <input type="text" name="login" id="login" value="" placeholder="Имя пользователя или почтовый ящик"/>
        </div>

        <div data-role="fieldcontain" class="ui-hide-label">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" value="" placeholder="Пароль"/>
        </div>
        
        <fieldset class="ui-grid-a">
            <div class="ui-block-a"><button type="submit" data-icon="user" id="submit">Войти</button></div>
            <div class="ui-block-b"><a href="/registration/" data-role="button" data-icon="key">Регистрация</a></div>
        </fieldset>

    </form>
    
    <a href="/lost_password/" data-role="button" data-icon="compass">Восстановление пароля</a>
        
</div>

<script type="text/javascript" src="/static/js/custom/login.js"></script>

<? 
    footer(); 
?>
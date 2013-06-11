<? 
    head('Восстановление пароля', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post">
        
        <ul data-role="listview" data-inset="true">
            
            <li data-role="fieldcontain">
                <label for="name">Имя пользователя или почтовый ящик</label>
                <input type="text" name="name" id="name" value=""/>
            </li>
    
        </ul>

        <input type="submit" id="submit" value="Продолжить" />
        
    </form>
    
</div>

<script src="/static/js/custom/lost_password.js"></script>

<?
    footer();
?>
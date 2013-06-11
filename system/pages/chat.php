<? 
    head('Чат', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <p id="chat" data-e="<?=get_elements()?>"></p>

    <?
        if(users::is_auth($auth_user)){
    ?>
    
    <ul data-role="listview" data-inset="true">
        <li>
            <form id="chat_send">
                <textarea name="text" id="text"></textarea>
                <button type="submit" id="submit">Отправить</button>
            </form>
        </li>
    </ul>
    
    <?
        
        }
    
        pages();
    
    ?>
    
    <? if(users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить сообщение?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-role="button" data-rel="back" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
    <? } ?>
    
</div>

<script src="/static/js/custom/chat.js"></script>

<?
    footer();
?>
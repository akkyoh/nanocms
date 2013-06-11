<? 
    head('Форум', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <p id="categories"></p>
    
    <p id="themes" data-e="<?=get_elements()?>"></p>
    
    <?
        pages();
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">
    
        <li data-role="list-divider">Навигация</li>
    
        <? if(users::is_auth($auth_user)){ ?><li data-icon="star"><a href="/forum_favorites/">Закладки</a></li><? } ?>
        
        <li data-icon="arrow-l"><a data-rel="back" href="#">Назад</a></li>
             
    </ul>
    
    <? if(users::is_admin($user_id)){ ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
        echo '<li data-icon="gear"><a href="/forum_category_add/">Добавить категорию</a></li></ul>';
            
    }
        
    ?>
        
    
    
    <? if(users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить категорию?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-rel="back" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
    <? } ?>
    
</div>

<script src="/static/js/custom/forum.js"></script>

<?
    footer();
?>
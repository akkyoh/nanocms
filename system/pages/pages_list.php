<? 

    if(!users::is_admin($user_id))
         exit;

    head('Страницы');    
?>

<div data-role="content">
       
    <p id="pages" data-e="<?=get_elements()?>"></p>

    <?
        pages();
    ?>

    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Навигация</li>
            
        <li data-icon="arrow-l"><a href="/">Меню</a></li>
        
    </ul>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Управление</li>
            
        <li data-icon="plus"><a href="/pages_add/">Добавить страницу</a></li>
        
    </ul>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить страницу?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-role="button" data-rel="back" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
</div>

<script src="/static/js/custom/pages_list.js"></script>

<? 
    footer();
?>
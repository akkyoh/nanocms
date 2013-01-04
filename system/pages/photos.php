<? 

    head('Фотографии', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
    
    if(isset($_GET['user']))
        $user_photos = $user_category = intval($_GET['user']);
    else{
        $user_photos = 0;
        $user_category = intval($user_id);
    }
    
?>

<div data-role="content">
    
    <p id="photos_last" data-user="<?=$user_photos?>" data-e="<?=get_elements()?>"></p>
    
    <?
        pages();
    ?>
    
    <p id="categories" data-user="<?=$user_category?>"></p>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">
    
        <li data-role="list-divider">Навигация</li>
    
        <li data-icon="arrow-l"><a data-rel="back" href="#">Назад</a></li>
             
    </ul>
    
    <? if($user_category == $user_id and users::is_auth($auth_user)){ ?>
    
        <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">

             <li data-role="list-divider">Управление</li>

             <li data-icon="gear"><a href="/photos_category_add/">Добавить категорию</a></li>

        </ul>
    
    <? } ?>
    
    <? if($user_category == $user_id and users::is_auth($auth_user) or users::is_admin($user_id)){ ?>
    
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

<script src="/static/js/custom/photos.js"></script>

<?
    footer();
?>
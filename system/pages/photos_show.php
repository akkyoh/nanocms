<? 

    $photo = photos::photo_data($_GET['id']);

    if($photo == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($photo['name'], $photo['name'], generate_keywords($photo['name']), 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$photo['name']).'/'); 
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <li data-role="list-divider">Фотография</li>
        
        <?
        
            echo '<li data-id="'.intval($photo['id']).'" data-icon="false" id="photo" data-user="'.intval($photo['user']).'"><img class="image-radius" src="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=preview" alt=""><h3 style="font-size: 14px">'.protect_echo($photo['name']).'</h3>';
            echo '<p>'.protect_echo($photo['description']).'</p><p class="ui-li-aside">'.date('d.m в H:i', $photo['date']).'</p></li>';
        
        ?>
        
    </ul>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Просмотр</li>
         
         <li><a href="#popup" data-rel="popup" data-position-to="window" data-transition="flip">Просмотр (<?=intval($photo['width'])?> x <?=intval($photo['height'])?>)</a></li>
         
         <li data-role="list-divider">Загрузка</li>
         
         <? echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;download" rel="external" target="_blank">Загрузка</a></li>'; ?>
         <? if($photo['width'] >= 1024 or $photo['height'] >= 1024) echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=1024&amp;download" rel="external" target="_blank">Загрузка ('.photos::get_size($photo, 1024).')</a></li>'; ?>
         <? if($photo['width'] >= 640 or $photo['height'] >= 640) echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=640&amp;download" rel="external" target="_blank">Загрузка ('.photos::get_size($photo, 640).')</a></li>'; ?>
         <? if($photo['width'] >= 360 or $photo['height'] >= 360) echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=360&amp;download" rel="external" target="_blank">Загрузка ('.photos::get_size($photo, 360).')</a></li>'; ?>
         <? if($photo['width'] >= 240 or $photo['height'] >= 240) echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=240&amp;download" rel="external" target="_blank">Загрузка ('.photos::get_size($photo, 240).')</a></li>'; ?>
         <? if($photo['width'] >= 128 or $photo['height'] >= 128) echo '<li><a href="/modules/photo_download/?id='.intval($photo['id']).'&amp;size=128&amp;download" rel="external" target="_blank">Загрузка ('.photos::get_size($photo, 128).')</a></li>'; ?>
         
         
    </ul>
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>

        <p id="comments" data-photos="<?=intval($_GET['id'])?>" data-e="<?=get_elements()?>"></p>

        <?
            if(users::is_auth($auth_user)){
        ?>
        
        <ul data-role="listview" data-inset="true">
            <li>
                <form id="comments_send">
                    <textarea name="text" id="text"></textarea>
                    <button type="submit" id="submit">Отправить</button>
                </form>
            </li>
        </ul>
        
        <?
            }
            pages();
        ?>

        <?
            if(users::is_admin($user_id) or $user_id == $photo['user']){
        ?>
        
        <div data-role="popup" id="popup_comment" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
            <div data-role="header" data-theme="a" class="ui-corner-top">
                <h1>Информация</h1>
            </div>
            <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
                <p>Вы действительно желаете удалить комментарий?</p>
                <fieldset class="ui-grid-a">
                    <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                    <div class="ui-block-b"><a href="#" id="delete_comment" data-role="button" data-rel="back" data-transition="flow" data-theme="b">Удалить</a></div>
                </fieldset>
            </div>
        </div>
        
        <?
            }
        ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
         
         <li data-icon="arrow-u"><a href="/photos_category/?category=<?=intval($photo['category'])?>">В категорию</a></li>
         <li data-icon="arrow-l"><a href="/photos/?user=<?=intval($photo['user'])?>">Список категорий</a></li>
         <li data-icon="arrow-d"><a href="/photos/">Все фотографии</a></li>
         
    </ul>
      
    <?

    if((users::is_auth($auth_user) and $user_id == $photo['user']) or users::is_admin($user_id)){
        
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
        echo '<li data-icon="minus"><a href="#popup_delete" data-rel="popup" data-position-to="window" data-transition="flip">Удалить фотографию</a></li></ul>';
            
    }
        
    ?>
        
    
    
    <div data-role="popup" id="popup" class="photo_popup" data-corners="false" data-tolerance="30,15" >
        <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Закрыть</a>
        <img src="/modules/photo_download/?id=<?=intval($photo['id'])?>" alt="">
    </div>

    <? if(users::is_admin($user_id) or $user_id == $photo['user']){ ?>
        
    <div data-role="popup" id="popup_delete" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить фотографию?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" data-id="<?=intval($_GET['id'])?>" data-category="<?=intval($photo['category'])?>" id="delete_photo" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
         
    <?
        }
    ?>
    
</div>

<script src="/static/js/custom/photos_show.js"></script>

<?
    footer();
?>
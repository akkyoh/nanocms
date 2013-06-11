<? 

    $file = files::file_data($_GET['id']);

    if($file == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($file['name'], $file['name'], generate_keywords($file['name']), 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$file['name']).'/'); 
    
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <li data-role="list-divider">Файл</li>
        
        <?
        
            if(!empty($file['description']))
                $file['description'] = protect_echo($file['description']).'<br>';
            
            echo '<li data-id="'.intval($file['id']).'" data-icon="false"><img class="image-radius" src="'.files::get_image($file['filetype'], $_GET['id']).'" alt=""><h3 style="font-size: 14px">'.protect_echo($file['name']).'</h3>';
            echo '<p>'.format_echo($file['description']);
            
            echo '<br>Загрузок: '.  number_format($file['download']);
            if(!empty($file['filetype']))
                echo '<br>Расширение: '.protect_echo($file['filetype']);
            if($file['size'] > 0)
                echo '<br>Размер: '.size_format(intval($file['size']));
            if($file['width'] > 0)
                echo '<br>Ширина: '.intval($file['width']).' пикселей';
            if($file['height'] > 0)
                echo '<br>Высота: '.intval($file['height']).' пикселей';
            if($file['bitrate'] > 0 and substr_count(files::get_mimetype($file['filetype']), 'audio') > 0)
                echo '<br>Битрейт: '.intval($file['bitrate']).' кбит/c';
            if($file['frequency'] > 0)
                echo '<br>Частота: '.intval($file['frequency']).' герц';
            
            echo '</p><p class="ui-li-aside">'.date('d.m в H:i', $file['date']).'</p></li>';
        
        ?>
        
    </ul>
    
    <?
    
    if(substr_count(files::get_mimetype($file['filetype']), 'audio') > 0){
    
    ?>
    
    <div style="width: 100%; text-align: center">
        <audio src="/modules/file_download/?id=<?=intval($file['id'])?>" preload="none" style="width: 100%" controls>
        </audio>
    </div>
    
    <?
    
    }
    
    if(substr_count(files::get_mimetype($file['filetype']), 'video') > 0){
    
    ?>
    
    <div style="width: 100%; text-align: center">
        <video width="250" height="187" preload="none" controls style="background-color: #000"><source src="/modules/file_download/?id=<?=intval($file['id'])?>" ></video>
    </div>
    
    <?
    
    }
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <?

        if(substr_count(files::get_mimetype($file['filetype']), 'image') > 0){
        
            echo '<li data-role="list-divider">Просмотр</li>';
            echo '<li><a href="#popup" data-rel="popup" data-position-to="window" data-transition="flip">Просмотр</a></li>';
        
        }
        
        echo '<li data-role="list-divider">Загрузка</li>';
        echo '<li><a href="/modules/file_download/?id='.intval($file['id']).'" rel="external" target="_blank">Загрузить</a></li>';
         
        ?>
         
    </ul>
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>

        <p id="comments" data-files="<?=intval($_GET['id'])?>" data-e="<?=get_elements()?>"></p>

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

        <? if(users::is_admin($user_id)){ ?>
        
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
        
        <? } ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
         <li data-icon="arrow-u"><a href="/files/?category=<?=intval($file['category'])?>&amp;n=<?=intval($_GET['nc'])?>">В категорию</a></li>
         <li data-icon="arrow-d"><a href="/files/?n=<?=intval($_GET['na'])?>">Все файлы</a></li>
         
    </ul>
      
    <?

    if(users::is_admin($user_id)){
    
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
        echo '<li data-icon="minus"><a href="#popup_delete" data-rel="popup" data-position-to="window" data-transition="flip">Удалить файл</a></li></ul>';
            
    }
        
    ?>
         
    
    
    <?
      
        if(substr_count(files::get_mimetype($file['filetype']), 'image') > 0){
    
    ?>
    
    <div data-role="popup" id="popup" class="photo_popup" data-corners="false" data-tolerance="30,15" >
        <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Закрыть</a>
        <img src="/modules/file_download/?id=<?=intval($file['id'])?>&amp;show" alt="">
    </div>
      
    <?
      
        }
    
    ?>
            
    <? if(users::is_admin($user_id)){ ?>
         
    <div data-role="popup" id="popup_delete" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить файл?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" data-id="<?=intval($_GET['id'])?>" data-category="<?=intval($file['category'])?>" id="delete_file" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
         
    <? } ?>
    
</div>

<script src="/static/js/custom/files_show.js"></script>

<?
    footer();
?>
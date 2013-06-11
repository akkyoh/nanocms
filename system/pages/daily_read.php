<? 
    
    $id = intval($_GET['id']);
    $note = daily::note_data($id);

    if($note == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
    
    head($note[0]['topic'], $note[0]['topic'], generate_keywords($note[0]['topic']), 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$note[0]['topic']).'/'); 
    
    daily::read_count($id);
    
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <li data-role="list-divider">Запись</li>
        
        <?
        
        echo '<li data-icon="false" id="note" data-user="'.intval($note[0]['user']).'">'.users::print_avatar($note[0]['user'], 2, '1.0').'<h3 style="font-size: 14px">'.protect_echo($note[0]['topic']).'</h3>
              <p>Прочитано: '.$note[0]['read'].'</p>';
        echo '<p class="ui-li-aside">'.date('d.m в H:i', $note[0]['date']).'</p></li>';
        
        $text = explode('[page]', $note[0]['text']);
        
        echo '<li style="font-weight: normal">'.format_echo(protect_echo($text[0])).format_echo(protect_echo($text[1])).'</li>';
        
        ?>
        
    </ul>
    
    <?
    
    if($note[0]['comments'] == 1){
        
        ?>
    
        <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>

        <p id="comments" data-daily="<?=$id?>" data-e="<?=get_elements()?>"></p>

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

        <? if((users::is_auth($auth_user) and $user_id == $note[0]['user']) or users::is_admin($user_id)){ ?>
        
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
        
    }
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
         <li data-icon="arrow-u"><a href="/daily_category/?category=<?=intval($note[0]['category'])?>">В категорию</a></li>
         <li data-icon="arrow-l"><a href="/daily/?user=<?=intval($note[0]['user'])?>">Список категорий</a></li>
         <li data-icon="arrow-d"><a href="/daily/">Все записи</a></li>
    
    </ul>

    <?

    if((users::is_auth($auth_user) and $user_id == $note[0]['user']) or users::is_admin($user_id)){
        
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
         
        echo '<li data-icon="info"><a href="/daily_edit/?id='.$id.'">Редактировать запись</a></li>';
        echo '<li data-icon="minus"><a href="#popup" data-rel="popup" data-position-to="window" data-transition="flip">Удалить запись</a></li></ul>';
            
    }
        
    ?>
         
    <? if((users::is_auth($auth_user) and $user_id == $note[0]['user']) or users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить запись?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" data-id="<?=$id?>" data-category="<?=intval($note[0]['category'])?>" id="delete" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
         
    <? } ?>
    
</div>

<script src="/static/js/custom/daily_read.js"></script>

<?
    footer();
?>
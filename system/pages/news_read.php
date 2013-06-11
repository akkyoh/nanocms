<? 
    
    $id = intval($_GET['id']);
    $news = news::current_news($id);

    if($news == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($news[0]['topic'], $news[0]['topic'], generate_keywords($news[0]['topic']), 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$news[0]['topic']).'/'); 
    
    news::read_count($id);
    
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <li data-role="list-divider">Новость</li>
        
        <?
        
        echo '<li data-icon="false">'.users::print_avatar($news[0]['user'], 2, '1.0').'<h3 style="font-size: 14px">'.protect_echo($news[0]['topic']).'</h3>
              <p>Прочитано: '.$news[0]['read'].'</p>';
        echo '<p class="ui-li-aside">'.date('d.m в H:i', $news[0]['date']).'</p></li>';
        
        $text = explode('[page]', $news[0]['text']);
        
        echo '<li><p>'.format_echo(protect_echo($text[0])).format_echo(protect_echo($text[1])).'</p></li>';
        
        ?>
        
    </ul>
    
    <?
    
    if($news[0]['comments'] == 1){
        
        ?>
    
        <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>

        <p id="comments" data-news="<?=$id?>" data-e="<?=get_elements()?>"></p>

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
        
        <?
        
    }
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
         <li data-icon="arrow-l"><a href="/news_category/?category=<?=intval($news[0]['category'])?>">В категорию</a></li>
         
    </ul>
      
    <?

    if(users::is_admin($user_id)){
        
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
        echo '<li data-icon="info"><a href="/news_edit/?id='.$id.'">Редактировать новость</a></li>';
        echo '<li data-icon="minus"><a href="#popup" data-rel="popup" data-position-to="window" data-transition="flip">Удалить новость</a></li></ul>';
            
    }
        
    ?>
         
    <? if(users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить новость?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" data-id="<?=$id?>" data-category="<?=intval($news[0]['category'])?>" id="delete" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
    <? } ?>
    
</div>

<script src="/static/js/custom/news_read.js"></script>

<?
    footer();
?>
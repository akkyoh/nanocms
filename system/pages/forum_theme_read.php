<? 

    $theme_data = forum::get_themes_data($_GET['id']);

    if($theme_data == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($theme_data['name'], $theme_data['name'], generate_keywords($theme_data['name']), 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$theme_data['name']).'/'); 
    
?>

<div data-role="content">
    
    <p id="messages" data-id="<?=intval($_GET['id'])?>" data-e="<?=get_elements()?>"></p>
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <?
        if($theme_data['close'] == 0 and users::is_auth($auth_user)){
    ?>
    
    <ul data-role="listview" data-inset="true">
        <li>
            <form id="message_send">
                <textarea name="text" id="markitup"></textarea>
                <button type="submit" id="submit">Отправить</button>
            </form>
        </li>
    </ul>
    <?
    
        }
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
    <?
    
    echo '<li data-icon="arrow-l"><a href="/forum_category/?id='.intval($theme_data['category']).'">Список тем</a></li>';
    echo '<li data-icon="arrow-l"><a href="/forum/">Список форумов</a></li></ul>';
       
    ?>
    
    <? if(users::is_auth($auth_user)){ ?>
         
         <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
            <li data-role="list-divider">Управление</li>

            <li data-icon="star" id="add_favorite" hide="<?=forum::is_favorite($user_id, $_GET['id'])?>"><a href="#" data-theme="<?=intval($_GET['id'])?>">Добавить в закладки</a></li>
            <li data-icon="minus" id="delete_favorite" hide="<?=!forum::is_favorite($user_id, $_GET['id'])?>"><a href="#" data-theme="<?=intval($_GET['id'])?>">Удалить из закладок</a></li>
         
         </ul>
            
    <? } ?>
         
    <? if(users::is_admin($user_id)){ ?>
         
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить сообщение?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-rel="back" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
         
    <? } ?>
         
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/bbcode/set.js"></script>

<script src="/static/js/custom/forum_theme_read.js"></script>

<?
    footer();
?>
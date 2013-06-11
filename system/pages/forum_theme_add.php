<? 
    page_auth();
    head('Создание темы');
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post" data-category="<?=intval($_GET['category'])?>">

        <ul data-role="listview" data-inset="true">
            
            <li data-role="list-divider">
                Название
            </li>
            
            <li>
                <input type="text" name="name" id="name"/>
                <p id="name_error" class="error_message"></p>
            </li>
            
            <li data-role="list-divider">
                Сообщение
            </li>
            
            <li>
                <textarea name="text" id="markitup"></textarea>
                <p id="text_error" class="error_message"></p>
            </li>
            
            <li>
                <input type="submit" id="submit" value="Создать">
            </li>
        
        </ul>

    </form>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Навигация</li>

        <li data-icon="arrow-l"><a href="/forum_category/?id=<?=intval($_GET['category'])?>">Список тем</a></li>

    </ul>
    
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/bbcode/set.js"></script>

<script src="/static/js/validation/forum_theme_add.js"></script>
<script src="/static/js/custom/forum_theme_add.js"></script>

<?
    footer();
?>
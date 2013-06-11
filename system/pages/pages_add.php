<? 

    if(!users::is_admin($user_id))
         exit;
    
    if(!isset($_GET['id']))
    {
        head('Добавление страницы');
    }
    else
    {
        head('Редактирование страницы');
        
        $id = intval($_GET['id']);
        $data_page = pages::get($id);
        
    }
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post">

        <ul data-role="listview" data-inset="true">

            <li data-role="list-divider">Заголовок</li>
            
            <li>
                <input type="text" name="title" id="title" value="<?=protect_echo($data_page['title'])?>"/>
                <p id="title_error" class="error_message"></p>
            </li>

            <li data-role="list-divider">Описание</li>
            
            <li>
                <input type="text" name="description" id="description" value="<?=protect_echo($data_page['description'])?>"/>
                <p id="description_error" class="error_message"></p>
            </li>

            <li data-role="list-divider">Ключевые слова</li>
            
            <li>
                <input type="text" name="keywords" id="keywords" value="<?=protect_echo($data_page['keywords'])?>"/>
                <p id="keywords_error" class="error_message"></p>
            </li>
            
            <li data-role="list-divider">Содержимое страницы</li>
            
            <li>
                <textarea name="page" id="markitup"><?=protect_echo($data_page['text'])?></textarea>
                <p id="page_error" class="error_message"></p>
            </li>
            
            <li>
                <input type="hidden" id="id" name="id" value="<?=$id?>">
                <input type="submit" id="submit" value="Продолжить">
            </li>
            
        </ul>
        
    </form>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Навигация</li>
            
        <li data-icon="arrow-l"><a href="/pages_list/">Список страниц</a></li>
        <li data-icon="arrow-d"><a href="/">Меню</a></li>
        
    </ul>
    
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/html/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/html/set.js"></script>

<script src="/static/js/validation/pages_add.js"></script>
<script src="/static/js/custom/pages_add.js"></script>

<?
    footer();
?>
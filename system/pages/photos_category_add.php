<? 

    page_auth();
    
    if(!isset($_GET['category']))
    {
        head('Добавление категории');
    }
    else
    {
        head('Редактирование категории');
        
        $category = intval($_GET['category']);
        $data_category = photos::data_category($category);
        
    }
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post">

        <ul data-role="listview" data-inset="true">

            <li data-role="list-divider">Данные категории</li>
            
            <li data-role="fieldcontain">
                <label for="name">Имя категории</label>
                <input type="text" name="name" id="name" value="<?=protect_echo($data_category['name'])?>"/>
                <p id="name_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="about">Описание категории</label>
                <textarea name="about" id="about"><?=protect_echo($data_category['about'])?></textarea>
                <p id="about_error" class="error_message"></p>
            </li>
            
            <li>
                <input type="hidden" id="id" name="id" value="<?=$category?>">
                <input type="submit" id="submit" value="Продолжить">
            </li>
            
        </ul>
        
    </form>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Навигация</li>
            
        <li data-icon="arrow-l"><a href="/photos/?user=<?=intval($user_id)?>">Список категорий</a></li>
        <li data-icon="arrow-d"><a href="/photos/">Все записи</a></li>
            
    </ul>
    
</div>

<script src="/static/js/validation/photos_category_add.js"></script>
<script src="/static/js/custom/photos_category_add.js"></script>

<?
    footer();
?>
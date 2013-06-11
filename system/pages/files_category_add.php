<? 

    if(!users::is_admin($user_id))
         exit;
    
    if(!isset($_GET['id'])){
    
        head('Добавление категории');
    
        $parent = intval($_GET['category']);
        
    }else{
        
        head('Редактирование категории');
        
        $category = intval($_GET['id']);
        $data_category = files::data_category($category);
        $parent = $data_category['parent'];
        
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
            
            <li data-role="fieldcontain">
                <label for="filetypes">Расширения файлов</label>
                <textarea name="filetypes" id="filetypes" value="<?=protect_echo($data_category['filetypes'])?>"></textarea>
                <p id="filetypes_error" class="error_message"></p>
            </li>
            
            <li>
                <input type="hidden" id="parent" name="parent" value="<?=intval($parent)?>">
                <input type="hidden" id="id" name="id" value="<?=intval($category)?>">
                <input type="submit" id="submit" value="Продолжить">
            </li>
            
        </ul>
        
    </form>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Навигация</li>

        <li data-icon="arrow-l"><a href="/files/?category=<?=intval($parent)?>">В категорию</a></li>

    </ul>
    
</div>

<script src="/static/js/validation/files_category_add.js"></script>
<script src="/static/js/custom/files_category_add.js"></script>

<?
    footer();
?>
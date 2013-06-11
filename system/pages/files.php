<? 

    head('Файлы', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 

?>

<div data-role="content">
    
    <p id="files" data-category="<?=intval($_GET['category'])?>" data-public="<?=intval()?>" data-e="<?=get_elements()?>" data-n="<?=intval($_GET['n'])?>"></p>
    
    <?
        pages();
    ?>
    
    <p id="categories"></p>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c" id="category_navigation">

         <li data-role="list-divider">Навигация</li>

         <li data-icon="arrow-l"><a href="#" id="category_back">Назад</a></li>
    
    </ul>
    
     <? if(users::is_admin($user_id)){ ?>
    
        <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">

             <li data-role="list-divider">Управление</li>

             <li data-icon="plus" id="add_files"><a href="#">Добавить файл</a></li>
             <li data-icon="plus" id="add_category"><a href="#">Добавить категорию</a></li>
             <li data-icon="info" id="files_edit"><a href="#">Редактировать файлы</a></li>
             <li data-icon="gear" id="category_edit"><a href="#">Редактировать категорию</a></li>

        </ul>

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

<script src="/static/js/custom/files.js"></script>

<?
    footer();
?>
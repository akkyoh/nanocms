<? 

    page_auth();
    head('Добавление фотографий'); 

?>

<div data-role="content" id="container">

        <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
	<div id="filelist" data-category="<?=intval($_GET['category'])?>">
            
        </div>
        
        <ul data-role="listview" data-inset="true">
                <li data-role="list-divider">Выберите файлы для загрузки (jpg, jpeg, gif, png)</li>
                <li class="ui-body">
        
                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a href="#" data-role="button" id="pickfiles">Выбрать</a></div>
                        <div class="ui-block-b"><a href="#" data-role="button" id="clean">Очистить</a></div>
                        
                    </div>
                    
                    <div class="ui-grid-solo">
                        <div class="ui-block-a"><a href="#" data-role="button" id="uploadfiles" data-theme="b">Загрузить</a></div>
                    </div>
                </li>
        </ul>
        
        <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li data-role="list-divider">Навигация</li>

            <li data-icon="arrow-l"><a href="/photos_category/?category=<?=intval($_GET['category'])?>">В категорию</a></li>
            <li data-icon="arrow-l"><a href="/photos/?user=<?=intval($user_id)?>">Список категорий</a></li>
            <li data-icon="arrow-d"><a href="/photos/">Все фотографии</a></li>

        </ul>
        
</div>

<script src="/static/js/plupload.js"></script>
<script src="/static/js/custom/photos_add.js"></script>

<? 
    footer();
?>
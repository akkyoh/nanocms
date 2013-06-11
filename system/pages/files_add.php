<? 

    if(!users::is_admin($user_id))
         exit;
    
    head('Добавление файлов'); 

    $filetypes = files::get_filetypes($_GET['category']);
    if(!empty($filetypes))
        $filetypes_text = ' (<span id="filetypes" data-types="'.protect_echo(str_replace(' ', '', $filetypes)).'">'.protect_echo($filetypes).'</span>)';
    else
        $filetypes_text = '<span id="filetypes" data-types="*"></span>';
    
?>

<div data-role="content" id="container">

        <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
	<div id="filelist" data-category="<?=intval($_GET['category'])?>">
            
        </div>
        
        <ul data-role="listview" data-inset="true">
            <li data-role="list-divider">Выберите файлы для загрузки<?=$filetypes_text?></li>
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

            <li data-icon="arrow-l"><a href="/files/?category=<?=intval($_GET['category'])?>">В категорию</a></li>
            <li data-icon="arrow-l"><a href="/files/">Список категорий</a></li>

        </ul>
        
</div>

<script src="/static/js/plupload.js"></script>
<script src="/static/js/custom/files_add.js"></script>

<? 
    footer();
?>
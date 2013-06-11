<? 
    
    if(!users::is_admin($user_id))
         exit;
    
    head('Файлы');
    
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <p id="files" data-category="<?=intval($_GET['category'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
    <?
    
    echo '<li data-icon="arrow-u"><a href="/files/?category='.intval($_GET['category']).'">В категорию</a></li>';
    echo '<li data-icon="arrow-l"><a href="/files/">Все файлы</a></li>';
       
    ?>
    
</div>

<script src="/static/js/custom/files_edit.js"></script>

<?
    footer();
?>
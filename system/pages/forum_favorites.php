<? 
    page_auth();
    head('Закладки');
?>

<div data-role="content">
    
    <p id="themes" data-e="<?=get_elements()?>"></p>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
    <?
    
    echo '<li data-icon="arrow-l"><a href="/forum/">Назад</a></li></ul>';
       
    ?>
    
</div>

<script src="/static/js/custom/forum_favorites.js"></script>

<?
    footer();
?>
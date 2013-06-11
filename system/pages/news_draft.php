<? 

    if(!users::is_admin($user_id))
         exit;

    head('Черновики');
?>

<div data-role="content">
    
    <p id="news" data-e="<?=get_elements()?>"></p>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
    echo '<li data-icon="plus"><a href="/news_edit/">Добавить новость</a></li>';
    echo '<li data-icon="arrow-l"><a href="/news/">Список категорий</a></li></ul>';
       
    ?>
    
</div>

<script src="/static/js/custom/news_draft.js"></script>

<?
    footer();
?>
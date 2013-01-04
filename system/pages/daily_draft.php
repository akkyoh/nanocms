<? 
    page_auth();
    head('Черновики');
?>

<div data-role="content">
    
    <p id="notes" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
    
         <li data-icon="arrow-l"><a href="/daily/?user=<?=intval($user_id)?>">Список категорий</a></li>
         <li data-icon="arrow-d"><a href="/daily/">Все записи</a></li>
         
    </ul>
         
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
         <li data-icon="plus"><a href="/daily_edit/">Добавить запись</a></li>

    </ul>
    
</div>

<script src="/static/js/custom/daily_draft.js"></script>

<?
    footer();
?>
<? 
    
    head('Записи', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/?category='.$_GET['category']); 
    
    $category_data = daily::data_category($_GET['category']);
    
?>

<div data-role="content">
    
    <p id="notes" data-category="<?=intval($_GET['category'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
         
         <li data-icon="arrow-l"><a href="/daily/?user=<?=intval($category_data['user'])?>">Список категорий</a></li>
         <li data-icon="arrow-d"><a href="/daily/">Все записи</a></li>
         
    </ul>
    
        <?
    
    if(users::is_auth($auth_user) and $category_data['user'] == $user_id){
        
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
        
        echo '<li data-icon="plus"><a href="/daily_edit/?category='.intval($_GET['category']).'">Добавить запись</a></li>';
        echo '<li data-icon="gear"><a href="/daily_category_add/?category='.intval($_GET['category']).'">Редактировать категорию</a></li></ul>';    
        
    }
    
    ?>
    
</div>

<script src="/static/js/custom/daily_category.js"></script>

<?
    footer();
?>
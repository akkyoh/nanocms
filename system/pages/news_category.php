<? 

    $category = news::data_category($_GET['category']);

    if($category == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($category['name'], NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/?category='.$_GET['category']); 
?>

<div data-role="content">
    
    <p id="news" data-category="<?=intval($_GET['category'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
         
         <li data-icon="arrow-l"><a href="/news/">Список категорий</a></li>
         
    </ul>
    
    <?
    
    if(users::is_admin($user_id)){
        
        ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
         <li data-icon="plus"><a href="/news_edit/?category=<?=intval($_GET['category'])?>">Добавить новость</a></li>
         <li data-icon="gear"><a href="/news_category_add/?category=<?=intval($_GET['category'])?>">Редактировать категорию</a></li></ul>
        
    <?
         
    }
    
    ?>
         
</div>

<script src="/static/js/custom/news_category.js"></script>

<?
    footer();
?>
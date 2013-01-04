<? 
    
    $category_data = photos::data_category($_GET['category']);

    if($category_data == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($category_data['name'], NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/?category='.$_GET['category']);
    
?>

<div data-role="content">
    
    <p id="photos" data-category="<?=intval($_GET['category'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
         
         <li data-icon="arrow-d"><a href="/photos/">Все фотографии</a></li>
         <li data-icon="arrow-l"><a href="/photos/?user=<?=intval($category_data['user'])?>">Список категорий</a></li>
         
    </ul>
    
    <?
    
    if(users::is_auth($auth_user) and $category_data['user'] == $user_id){
    
    ?>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
      
    <?
        
        echo '<li data-icon="plus"><a href="/photos_add/?category='.intval($_GET['category']).'">Добавить фотографии</a></li>';
        echo '<li data-icon="info"><a href="/photos_category_edit/?category='.intval($_GET['category']).'">Редактировать фотографии</a></li>';
        echo '<li data-icon="gear"><a href="/photos_category_add/?category='.intval($_GET['category']).'">Редактировать категорию</a></li></ul>';
        
    }
       
    ?>
         
         
    
</div>

<script src="/static/js/custom/photos_category.js"></script>

<?
    footer();
?>
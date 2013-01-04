<? 
    
    page_auth();

    head('Фотографии');
    
    $category_data = photos::data_category($_GET['category']);
    
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <p id="photos" data-category="<?=intval($_GET['category'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
        
    <?
    
    if(users::is_auth($auth_user) and $category_data['user'] == $user_id){
        
        echo '<li data-icon="arrow-u"><a href="/photos_category/?category='.intval($_GET['category']).'">В категорию</a></li>';
        
        
    }
    
    echo '<li data-icon="arrow-l"><a href="/photos/?user='.intval($category_data['user']).'">Список категорий</a></li>';
       
    ?>
         
         <li data-icon="arrow-d"><a href="/photos/">Все фотографии</a></li></ul>
    
</div>

<script src="/static/js/custom/photos_category_edit.js"></script>

<?
    footer();
?>
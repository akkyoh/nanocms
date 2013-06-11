<? 

    $category = forum::data_category($_GET['id']);

    if($category == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    head($category['name'], NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/?id='.intval($_GET['id'])); 
?>

<div data-role="content">
    
    <p id="themes" data-id="<?=intval($_GET['id'])?>" data-e="<?=get_elements()?>"></p>
    
    <?
    
        pages();
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
         
         <li data-icon="arrow-l"><a href="/forum/">Список форумов</a></li>
    
    </ul>
    
    <?
    
    if(users::is_auth($auth_user)){
        
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
    
         <li data-icon="plus"><a href="/forum_theme_add/?category=<?=intval($_GET['id'])?>">Создать тему</a></li>
         <? if(users::is_admin($user_id)){ ?><li data-icon="gear"><a href="/forum_category_add/?category=<?=intval($_GET['id'])?>">Редактировать категорию</a></li><? } ?>
         
    </ul>
    
    <?
    
    }
    
    ?>
    
    <? if(users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup">
        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-divider-theme="c">
            <li data-role="list-divider">Управление</li>
            <li data-icon="minus"><a href="#" data-rel="back" id="close">Закрыть</a></li>
            <li data-icon="arrow-u"><a href="#" data-rel="back" id="warning">Закрепить</a></li>
            <li data-icon="delete"><a href="#" data-rel="back" id="delete">Удалить</a></li>
        </ul>
    </div>
    
    <? } ?>
    
</div>

<script src="/static/js/custom/forum_category.js"></script>

<?
    footer();
?>
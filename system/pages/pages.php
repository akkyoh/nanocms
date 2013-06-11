<? 

    $id = intval($_GET['id']);
    $data_page = pages::get($id);
    
    if($data_page == false)
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
    else
        head($data_page['title'], $data_page['description'], $data_page['keywords'], 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'.generate_url($_GET['id'].'_'.$data_page['title']).'/'); 
    
?>

<div data-role="content">
    
    <?
    
        if($data_page == false)
            echo 'Страница не найдена.';
        else
            echo $data_page['text'];
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Навигация</li>
        
        <? if(users::is_admin($user_id)){ ?><li data-icon="arrow-r"><a href="/pages_list/">Список страниц</a></li> <? } ?>
        <li data-icon="allow-l"><a data-rel="back" href="#">Назад</a></li>
        
    </ul>
    
    <? if(users::is_admin($user_id)){ ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Управление</li>
            
        <li data-icon="gear"><a href="/pages_add/?id=<?=$id?>">Редактировать страницу</a></li>
        
    </ul>
    
    <? } ?>
    
</div>

<? 
    footer();
?>